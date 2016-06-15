# Universal-Translate-Wrapper
Universal PHP class the allows you to wrap text in any t() function to translate from english to a second language.


## Installation
1) Import /database/schema.sql to your database to create the cached table
2) Rename config.sample.inc and set your Bing Translation API credentials and your database connection string

## Usage

1) From any PHP file insert the line   
require_once('lib/bing.translate.php');

2) Call the function like so from your PHP file
echo t("Who is George Washington?","es");

The first variable is the text you want translated and the second variable is the language you'd like it translated to.  For a list of languages see the link below.

## Supported languages

You can find a list of supported languages here:
https://msdn.microsoft.com/en-us/library/hh456380.aspx


## Thank you

Bing translation class provided by Sebastian Brosch <sebastian.brosch@brosch-software.de>
(c) 2012-2013, Sebastian Brosch & Brosch Software
