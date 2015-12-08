# kirby-booking-manager-plugin

Version 1.0.1

A plugin for the [Kirby 2 CMS System](http://getkirby.com) to recieve and manage bookings.

It could be used for hotel room bookings or restauraunt reservations as well as any other, time-related service.

Right now there is only a pre-payment option aviable, but PayPal as well as other integrations are on their way.

If somebody does a booking they get a confirmation Email, as well as you or the assigned contact person gets an information Email, that contains a url to confirm the booking, which will result in another mail to the customer, that gets a final confirmation.

You will need a proper mailserver setup to use the plugin that depends on it to send the confirmation mails.
For local installation e.g. xampp you can use this guide: http://stackoverflow.com/a/18185233

## Features in current release v.1.0.1

- Create Products, with price, description and title
- Set a time range for the booking or leave it "unlimited"
- Set a currency
- Set a contact mail address, which gets all the bookings
- Get bookings via a booking form
- Enter the confirmation and success text for the customer in the panel
- You get an eMail with the booking and a url to confirm it
- After the confirmation, the customer gets another final confirmation

## Planned features for future Versions

- Pay the booking directly using PayPal and other payment services
- Manage bookings and customer in the panel (Edit, create, delete)
- Manage booking criteria (form-fields) in the panel
- Capacity planning for services (multiple time ranges and blocked time ranges)
- Proper error handling of mailserver issues

## Installation

1. Put the `bookingManager` directory to `site/plugins`.

2. Put the `bookingManager_bookingForm.php` and the `sendBookingMail.php` snippet in `snippets`.

3. Put the `assets/css/`-files to `assets/css`.

4. Put the `assets/javascript/`-files to `assets/javascript`.

5. Change the `site/snippets/header.php` and `site/snippets/footer.php` with our changes or replace the complete file. 

6. Change the `site/blueprints/site.php` with our changes or replace the complete file. 


### a) Using our Booking Manager Page

1. Put the `blueprints/booking-manager.php` into your `blueprints` folder.

2. Put the `templates/booking-manager.php` into your `templates` folder.

3. Put the `content/booking-manager` Folder into your `content` folder.


### a) Using the Booking Manager on your custom Page

1. Use the following Snippet in any Page Template, where you want the booking Form area to be shown.

		<?php snippet('bookingManager_bookingForm') ?>

2. Add the following fields to the blueprint of the same page.

		bookingTitle:
			label: Title of the Service you want to offer
			type: text
		bookingDescription:
			label: Description of the Service you want to offer
			type: textarea
		products:
			label: Products
			type: structure
		entry: >
			<h1>{{ title }}</h1>
			<p><b>Description:</b> {{ description }}</p>
			<p><b>Price:</b> {{ price }}</p>
		fields:
			title:
				label: Title
				type: text
			description:
				label: Description
				type: textarea
			price:
				label: Price
				type: number
			booking-start:
				label: Begin of Booking Term
				type: date
				format: YYYY-MM-DD
			booking-end:
				label: End of Booking Term
				type: date
				format: YYYY-MM-DD
			paymentMethods:
				label: Payment Methods
				type: checkboxes
				options:
					prepay: Pre-Pay
					paypal: PayPal
			currency:
				label: Currency (€ or EUR)
				type: text
				placeholder: EUR
				default: $
			bookingMail:
				label: E-Mail for Booking requests
				type: email
				required: true
			confirmationText:
				label: Order Confirmation
				type: textarea
			successText:
				label: Order Success Confirmation
				type: textarea
3. Be sure to fill out all of the fields and save the page before you first try to have a view on the page. If you don't you will get ugly error messages.

## Usage
1. Configure your personal Data, especially the mail contact, as well as Mailtexts in the panel on the page where you inserted the fields (or on the Booking Manager Page if you used our template).
2. Start Adding products.
3. Have Fun :)
