# Overview
Constructs submodule for the [Getunik Campaign Template](https://bitbucket.org/getunik/getunikcampaigntemplate).

# Features

## Donation Widget
The donation widget functionality consists of three distinct parts:
1. The widget configuration (`widget` blueprint)
2. Widget checkout and thanks page (`page.widget` and `page.widget-thanks` blueprints)
3. Donation amount selector and donation sample sections for the landingpage (`section.amountselector` and `section.donationsamples` blueprints)

Widget configurations have to be created under the path `system/widgets`.

### Configuration Options
* `widget.baseUrl` (defaults to `"https://widget.raisenow.com/widgets/lema/"`)
  Base URL from which the widget will be loaded.
* `widget.testMode` (defaults to `true`)
  If set to true, the widget will be in test-mode. Use environment specific configuration files to control test-/prod-mode for the different environments.
* `widget.moduleLocations` (defaults to `['js/widget-modules', '/assets/js/widget-modules']`)
  The paths where the widget implementation will go looking for widget JS modules.
* `widget.defaultModules` (defaults to `['amount-options']`)
  Default modules are the widget modules that are loaded for all widgets - as opposed to the ones that can be selected manually on the widget configuration.


### E-Commerce Tracking
TODO
