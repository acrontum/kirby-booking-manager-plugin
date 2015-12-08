<?php if(!defined('KIRBY')) exit ?>

title: Booking Manager
pages: false
fields:
	title:
		label: Title of the Service you want to offer
		type: text
		required: true
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
				required: true
			description:
				label: Description
				type: textarea
				required: true
			price:
				label: Price
				type: text
				validate: 
					num
				help: Please type in a number
			booking-frame:
				label: Set booking time frame
				type: checkbox
				text: Do you want to pick a specific booking time frame for the product?
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
		validate: email
		required: true
	confirmationText:
		label: Order Confirmation
		type: textarea
		required: true
	successText:
		label: Order Success Confirmation
		type: textarea
		required: true
