## About The Project

The problem was to many markers on map, so we have to make condition to show/hide triggered by button in google maps.

### Built With

This section should list any major frameworks that you built your project using. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.
* [Codeigniter](https://codeigniter.com)
* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)
* [Google Maps API](https://developers.google.com/maps)

<!-- GETTING STARTED -->
## Getting Started

This is an example of how you may give instructions on setting up your project locally.
To get a local copy up and running follow these simple example steps.

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/mrskl21/google-maps-show-polygons-by-ajax.git
   ```

2. Import database using sql file in `database/msc_lingkungan.sql`

3. Rename `aplication/config/database.php.example` to `aplication/config/database.php` and update the configuration on line 79-81

4. Enter your Google-API-key in `aplication/view/maps.php` on line 140
   ```html
   <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=myMap"></script>
   ```
