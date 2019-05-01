<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 *
 * @return string
 * @throws \Exception
 */
function asset_path( $asset ) {
	return mix( $asset );
}

/**
 * Get the path to the public folder.
 *
 * @param  string  $path
 *
 * @return string
 */
function public_path( $path = '' ) {
	return config( 'theme.dir' ) . '/public' . ( $path ? DIRECTORY_SEPARATOR . ltrim( $path, DIRECTORY_SEPARATOR )
			: $path );
}

/**
 * Get the uri to the public folder.
 *
 * @param  string  $path
 *
 * @return string
 */
function public_uri( $path = '' ) {
	return config( 'theme.uri' ) . '/public' . ( $path ? DIRECTORY_SEPARATOR . ltrim( $path, DIRECTORY_SEPARATOR )
			: $path );
}

/**
 * Get the path to a versioned Mix file.
 *
 * @param  string  $path
 *
 * @return string
 */
function mix( $path ) {
	static $manifests = [];

	if ( ! starts_with( $path, '/' ) ) {
		$path = "/{$path}";
	}

	if ( file_exists( public_path( '/hot' ) ) ) {
		$url = rtrim( file_get_contents( public_path( '/hot' ) ) );

		if ( starts_with( $url, [ 'http://', 'https://' ] ) ) {
			return str_after( $url, ':' ) . $path;
		}

		return "//localhost:8080{$path}";
	}

	$manifestPath = public_path( '/mix-manifest.json' );

	if ( ! isset( $manifests[ $manifestPath ] ) ) {
		if ( ! file_exists( $manifestPath ) ) {
			return public_uri( $path );
		}

		$manifests[ $manifestPath ] = json_decode( file_get_contents( $manifestPath ), true );
	}

	$manifest = $manifests[ $manifestPath ];

	if ( ! isset( $manifest[ $path ] ) ) {
		return public_uri( $path );
	}

	return public_uri( $manifest[ $path ] );
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}
