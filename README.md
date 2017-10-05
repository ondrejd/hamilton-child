# Hamilton Child Theme
Child of __Hamilton theme__ by [Anders Norén][6] used on [ondrejd.com][2] site.

## New Features
Here is a list of new features that brings this child theme:
+ full __Czech localization__ (included also localization of parent theme),
+ updates in [WordPress Theme Customizer][7]:
  - section __Colors__ - new options _Secondary background color_, _Foreground color_, _Highlight Color_,
  - section __Theme options__ - new options _Site description_, _Footer text_, ~~_Cookie warning_~~,
  - new section __Blog Page Display__ - with options _Show blog filter_, _Show Category_, _Show Date and Time_, _Show Excerpt_ and _Show Tags_,
  - ~~new sections for better support of __WooCommerce__~~,
  - ~~section __Login Page Display__ with options: _..._~~,
+ support for [WooCommerce][8] plugin,
+ ~~default [WordPress][1] __Login Page__ has same style as rest of the site~~,
+ ~~same style for _WP_ login page as for the rest of the site~~,
+ ~~templates for some _custom post types_ from my plugins - _notice_ from plugin [Notices Generator][3], _project_ from [odwp-projects][4] and *odwpdp_cpt* from [Downloads Plugin][5]~~.

## Installation
+ unpack archive with theme into your `/wp-content/themes` directory,
+ go into [WordPress][1] administration and install also __Hamilton__ theme,
+ now is time to activate __Hamilton Child__ theme.

## TODO
Features which was crossed above are also here in _TODO_ list:
+ updates in [WordPress Theme Customizer][7]:
  - section __Theme options__ - new option _Cookie warning_
  - new sections for better support of __WooCommerce__,
  - section __Login Page Display__ with options: _..._,
+ templates for some _custom post types_ from my plugins - _notice_ from plugin [Notices Generator][3], _project_ from [odwp-projects][4] and *odwpdp_cpt* from [Downloads Plugin][5],
+ __issues/bugs__:
  - when _fancy ordering_ is open main menu button should be hidden,
  - _main_ menu items ~~and _fancy_ordering_ menu items~~ should have same `0.25em` border,
  - _fancy ordering_ menu should have same footer as _main_ menu,
  - closing button of the _fancy ordering_ menu should be at exact same place as opening button,
  - in `Hamilton_Child_Customizer::header_output()` should be CSS/JS output minified and cached.

## Screenshots
Here are screenshots that came from my local development version:

### Desktop
[![Front page on desktop](screenshot.png)](screenshot.png)

### Tablet
[![Front page on tablet](screenshot-tablet.png)](screenshot-tablet.png)

### Mobile
[![Front page on mobile](screenshot-mobile.png)](screenshot-mobile.png)

[1]:https://wordpress.org/
[2]:https://ondrejd.com/
[3]:https://github.com/ondrejd/odwp-notices_generator
[4]:https://github.com/ondrejd/odwp-projects
[5]:https://github.com/ondrejd/od-downloads-plugin
[6]:http://www.andersnoren.se/
[7]:https://developer.wordpress.org/themes/customize-api/
[8]:https://woocommerce.com/
