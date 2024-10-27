=== AI Alt Text Generator ===
Contributors: migkapa
Tags: images, alt text, AI, OpenAI, accessibility
Requires at least: 4.6
Tested up to: 6.5.3
Requires PHP: 7.0
Stable tag: 2.0.4
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

AI Alt Text Generator uses artificial intelligence to automatically create clear and detailed descriptions for images, improving website accessibility and SEO.

== Description ==
AI Alt Text Generator utilizes the power of ChatGPT ( OpenAI ) to automatically generate alt text for images on your WordPress site. This plugin connects to OpenAI's API to provide intelligent and contextually relevant alt text, making your website more accessible and SEO-friendly.

New:
- Switched to use GPT-4o mini for faster and way cheaper experience.

Important: This plugin requires an external service (OpenAI) for its core functionality.

== Installation ==

1. Upload the plugin files to the /wp-content/plugins/ai-alt-text-generator directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Obtain an OpenAI API key (required). Visit OpenAI's website and sign up to get your API key.
4. Use the plugin through the 'Alt Text Generator' admin page to configure the plugin with your OpenAI API key.

== Frequently Asked Questions ==
= Does this plugin require an OpenAI API key? =

Yes, an OpenAI API key is required to use this plugin. You can obtain one by signing up at OpenAI's website.

= How does this plugin use the OpenAI API? =

The plugin sends images to OpenAI's API, which then returns the generated alt text. This process requires an active internet connection and the transmission of data to OpenAI's servers.

= Can I generate alt text for multiple images at once? =

Yes, the AI Alt Text Generator supports bulk processing of images.

= Can I use a custom prompt? =

Yes now you can use a custom prompt to generate alt text in the plugin settings.

== Screenshots ==

https://lajmeshkurt.com/wp-content/uploads/2024/01/screenshot_1.png
https://lajmeshkurt.com/wp-content/uploads/2024/01/screenshot_2.png
https://lajmeshkurt.com/wp-content/uploads/2024/01/screenshot_3.png

== Changelog ==

= 2.0.4 =
- fixed admin page rendering issue

= 2.0.3 =
- switched to GPT-4o-mini for cheaper and faster experience

= 2.0.2 =
- fixed grid view not showing "Generate Alt Text" button

= 2.0.1 =
- Added the new GPT-4o model for 50% cheaper and faster experience.
- Added custom prompt functionality.
- Added option to choose language.

= 1.0.0 =
- Initial release.

== External Service Usage Disclosure ==
This plugin uses the OpenAI API to generate alt text. Data (images and their metadata) is sent to OpenAI for processing. For more information, please review the OpenAI Terms of Use and Privacy Policy.
