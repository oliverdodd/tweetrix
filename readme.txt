=== tweetrix ===
Contributors: 01001111
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=11216463
Tags: widget, twitter, cloud, javascript
Requires at least: 2.0.2
Tested up to: 2.9
Stable tag: trunk

Display a word cloud representing the content of up to 200 tweets from a publicly accessible Twitter feed.

== Description ==

The tweetrix widget/plugin will allow you to display a word cloud from up to 200 tweets from a publicly accessible Twitter feed (preferably your own).  You can configure:

* the user (or the twitterapi feed by default)
* the number of tweets
* the minimum number of repetitions required to include a particular word
* the minimum number of letters required to include a particular word
* the minimum and maximum font sizes, the size increment, and their units
* a word filter to exclude common words or other undesirables
* filters for @usernames, links, and numbers
* a wrapper div for CSS convenience

== Installation ==

1. Upload 'tweetrix.php' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the widget in the widget section.

To use as a plugin in your theme, include the following:
`<php	$t = new Tweetrix($params);
	$t->output(); ?>`

Where $params is an associative array containing any of the following keys (descriptions and default values listed):

* user			- the username (twitterapi)
* nTweets		- the number of tweets to include (200)
* minRepetitions	- the minimum number of occurrences for a word (1)
* minWordLength		- the minimum length of a word (3)
* wordFilter		- the word filter
* minFontSize		= the minimum font size (.8)
* maxFontSize		= the maximum font size (3)
* deltaSize		= the change in size per occurrence (.2)
* fontUnits		= the font units em/px/pt (em)
* filterUsernames	= filter out @usernames? (true)
* filterURLs		= filter out urls? (true)
* filterNumbers		= filter out numerals? (true)
* divid			= the id of the div (tweetrix)


== Frequently Asked Questions ==

= Why don't you support authentication? =

Because the processing is done in Javascript, not PHP, so your password would be clearly visible.

= Then why is this in Javascript and not PHP? =

Twitter imposes a 100 request per hour limit on single users or IPs.  If this was written in PHP, all the requests would come from one single source (your web host).  In this case, once you exceeded 100 views in an hour, visitors to your blog would no longer receive any content for the tweetrix plugin.  By writing the functionality in javascript, the requests are coming from the client rather than your server.

= How do I change the style? =

In your theme css file (or somewhere on your page), add styles for #tweetrix (if you've left the div id option set to tweetrix).  The individual words are wrapped in span tags.

== Screenshots ==

None at the moment.

== Changelog ==

= 1.0.2 =
* Altered the way options are processed.

= 1.0.1 =
* Fixed a bug that broke the widget page.

= 1.0.0 =
* First release.

== Upgrade Notice ==

= 1.0.2 =
* Altered the way options are processed (which previously had a few issues).

= 1.0.1 =
* Fixed a bug that broke the widget page.
