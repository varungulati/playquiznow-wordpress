=== PlayQuizNow ===
Contributors: playquiznow
Tags: quiz, embed, interactive, assessment, education
Requires at least: 5.8
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed interactive quizzes from PlayQuizNow into your WordPress site with a shortcode or Gutenberg block.

== Description ==

PlayQuizNow lets you create beautiful, interactive quizzes and embed them anywhere on your WordPress site. Use the `[playquiznow]` shortcode or the Gutenberg block to add quizzes to posts, pages, and widget areas.

**Features:**

* Shortcode and Gutenberg block support
* Auto-resize via postMessage — no scrollbars
* Light and dark theme support
* Lazy loading for better page performance
* Google Analytics event tracking on quiz completion
* Configurable default settings
* "Powered by PlayQuizNow" branding (can be turned off)

== Installation ==

1. Upload the `playquiznow` folder to `/wp-content/plugins/`.
2. Activate the plugin through the Plugins menu.
3. Go to Settings → PlayQuizNow to configure defaults.
4. Add quizzes using the shortcode or Gutenberg block.

== Frequently Asked Questions ==

= How do I find my quiz ID? =

Log in to your PlayQuizNow dashboard at [playquiznow.com](https://playquiznow.com). Each quiz has a unique ID shown on its settings page.

= Can I embed multiple quizzes on one page? =

Yes. Each shortcode or block operates independently.

= Does the quiz auto-resize? =

Yes. The embedded quiz communicates its height via postMessage and the iframe adjusts automatically.

= Can I track quiz completions in Google Analytics? =

Yes. If Google Analytics (gtag.js) is loaded on your site, a `quiz_complete` event is fired automatically when a user finishes a quiz.

== Changelog ==

= 1.0.0 =
* Initial release.
* Shortcode support: `[playquiznow id="your-quiz-id"]`.
* Gutenberg block with live preview and sidebar settings.
* Auto-resize via postMessage.
* Admin settings page with defaults.
* Google Analytics quiz completion tracking.
* Light and dark theme support.
* Lazy loading option.
