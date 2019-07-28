<?php

namespace Drupal\trailing_slash\PathProcessor;

use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TrailingSlashPathProcessor
 *
 * @package Drupal\trailing_slash\PathProcessor
 */
class TrailingSlashPathProcessor implements OutboundPathProcessorInterface {

  /**
   * Add trailing slash for everybody paths.
   *
   * @param string $path
   * @param array $options
   * @param \Symfony\Component\HttpFoundation\Request|NULL $request
   * @param \Drupal\Core\Render\BubbleableMetadata|NULL $bubbleable_metadata
   * @return string|string[]|null
   */
  function processOutbound($path, &$options = array(), Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    // Skip trailing slash for front page and admin pages.
    if ($path == '/' || empty($path) || (bool) strstr($path, '/admin')) {
      return $path;
    }
    // Skip for transliterate url
    if ((bool) strstr($path, '/machine_name/transliterate')) {
      return $path;
    }
    // Skip for user reset url.
    if ((bool) strstr($path, '/user/reset')) {
      return $path;
    }
    return preg_replace('/((?:^|\\/)[^\\/\\.]+?)$/isD', '$1/', $path);
  }
}
