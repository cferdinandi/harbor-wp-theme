# Documentation

## Getting Started

1. [Download Harbor.](https://github.com/cferdinandi/harbor-wp-theme/archive/master.zip)
2. Upload Harbor to your site via FTP or the WordPress theme installer.
3. Activate Harbor in the WordPress theme dashboard.

To make sure you always get the latest updates, it's recommended that you also install the [GitHub Updater plugin](https://github.com/afragen/github-updater).

## Contents

- [Getting Started](#getting-started)
- [Basic Appearance](#basic-appearance)
    - [Picking a typeface](#picking-a-typeface)
    - [Adding a logo](#adding-a-logo)
    - [Adding a site icon](#adding-a-site-icon)
    - [Creating a menu](#creating-a-menu)
- [Donations](#donations)
    - [Donations form](#donations-form)
    - [Donations buttons](#donations-buttons)
- [Petfinder](#petfinder)
- [Page and Post Content](#page-and-post-content)
    - [Add a hero image header](#add-a-hero-image-header)
    - [Create an image gallery](#create-an-image-gallery)
    - [Create a button link](#create-a-button-link)
    - [Add a call-to-action at the end of blog posts](#add-a-call-to-action-at-the-end-of-blog-posts)
    - [Disable comments site-wide](#disable-comments-site-wide)
    - [Animal Shelter Manager forms](#animal-shelter-manager-forms)
- [Footer Content](#footer-content)
- [Recommendations](#recommendations)
    - [Plugins](#plugins)
    - [Web Hosting](#web-hosting)

## Basic Appearance

### Picking a typeface

<iframe width="420" height="315" src="https://www.youtube.com/embed/xHBd6xKhfjs?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Appearance > Theme Options`, and select your preferred font. Click `Save` at the bottom of the page when you're done.

### Adding a logo

<iframe width="420" height="315" src="https://www.youtube.com/embed/qYdGlF_mOds?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Appearance > Customize`, and select `Logo`. Click `Select Image`, and upload your preferred logo image. Click `Save & Publish` at the top of the page when you're done.

### Adding a site icon

<iframe width="420" height="315" src="https://www.youtube.com/embed/mHcJIu70GGU?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Appearance > Customize`, and select `Site Identity`. Click `Select Image`, and upload your preferred icon image. Click `Save & Publish` at the top of the page when you're done.

### Creating a menu

<iframe width="420" height="315" src="https://www.youtube.com/embed/sosfcXx2uwA?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

Harbor uses WordPress's built-in menu functionality. Visit `Appearance > Menus` to get started. `Primary` is the header navigation, and `Secondary` is the footer navigation. The primary navigation supports one level of submenus (as dropdown menus). The secondary navigation only supports a flat navigation structure.

## Donations

From the WordPress Admin Dashboard, visit `PayPal Donations`. Add your information, and click `Save` at the bottom of the page when you're done.

### Donations Form

<iframe width="420" height="315" src="https://www.youtube.com/embed/bKATL2cypZw?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

Display your donations form on any page by using the `[[paypal_donations_form]]` shortcode. [View the live donation form demo.](http://localhost:8888/harbor/wordpress/donate/)

### Donations Buttons

<iframe width="420" height="315" src="https://www.youtube.com/embed/MIA27R-GYKY?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

You can also create one-off PayPal donation buttons using the `[[paypal_donations_button]]` shortcode.

**Example:**

[paypal_donations_button amount="25" label="Donate $25" recurring="true" description="Donate $25 to the Special Fund"]

```lang-php
[[paypal_donations_button amount="25" label="Donate $25" recurring="true" description="Donate $25 to the Special Fund"]]
```

If `amount` is left blank, donors will be asked to write in their own amount when they're sent to PayPal. All other fields are optional. `recurring="true"` makes the donation recurring. `description` is what is displayed on PayPal.com.

## Petfinder

<iframe width="420" height="315" src="https://www.youtube.com/embed/BDGlBVhJE74?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Pet Listings > Options`. Add your information, select which filters should be visible, and click `Save` at the bottom of the page when you're done.

By default, your list of adoptable animals is displayed at `http://yourwebsite.com/pets`. This can be changed in the options.

[View the live pet listings demo.](http://localhost:8888/harbor/wordpress/pets/)

## Page and Post Content

### Add a hero image header

<iframe width="420" height="315" src="https://www.youtube.com/embed/7KWSOeJr63c?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

Underneath the content section is a `Page Hero` section. Add your hero content there. In addition to text, you can also add an image or video.

To apply a background image to the hero, use the `Featured Image` section in the sidebar. If text is hard to read on the background image, check the box to add a `Background Image Overlay`.

### Create an image gallery

<iframe width="420" height="315" src="https://www.youtube.com/embed/X5EFKavGKnY?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

Create beautiful, mosaic image galleries using the `[[gallery]]` shortcode, or the built-in gallery feature in the WordPress editor. View the [Image Galleries page](http://localhost:8888/harbor/wordpress/gallery/) to see a working example.

### Create a button link

<iframe width="420" height="315" src="https://www.youtube.com/embed/FIHBKyGNYsQ?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

Add bold calls to action in your content with the `[[button]]` shortcode:

[button link="#create-a-button-link" label="Click Me"]

```lang-markup
[[button link="#create-a-button-link" label="Click Me"]]
```

To make a button extra large, also include the `size` attribute with the value `large`:

[button link="#create-a-button-link" label="Large Click Me" size="large"]

```lang-markup
[[button link="#create-a-button-link" label="Large Click Me" size="large"]]
```

### Add a call-to-action at the end of blog posts

<iframe width="420" height="315" src="https://www.youtube.com/embed/xSKWL_TA_5A?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Posts > Post Options`, and add your content. Click `Save` at the bottom of the page when you're done.

### Disable comments site-wide

<iframe width="420" height="315" src="https://www.youtube.com/embed/cXSrhQZj05s?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Posts > Post Options`, and click `Disable comments on all blog posts`. Click `Save` at the bottom of the page when you're done.

### Animal Shelter Manager forms

If you use [Animal Shelter Manager](http://sheltermanager.com) to manager your pets, Harbor includes a shortcode that makes it easy to embed adoption applications and other forms with the `[[asm_forms]]` shortcode. Just include the URL for the form and Harbor handles the rest.

```lang-markup
[[asm_forms url="https://us2.sheltermanager.com/service?account=aa1111&method=online_form_html&formid=1"]]
```

## Footer Content

<iframe width="420" height="315" src="https://www.youtube.com/embed/uUDDyqpZ8ZI?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

From the WordPress Admin Dashboard, visit `Appearance > Theme Options`, and add links to your accounts. Items left blank will be skipped. You can also add footer content. Click `Save` at the bottom of the page when you're done.

## Recommendations

Recommended plugins and services to get the most impact out of your site.

### Plugins

- [GitHub Updater](https://github.com/afragen/github-updater) will allow you to automatically update your website when new versions of this theme come out.
- [JetPack](https://wordpress.org/plugins/jetpack/) adds a ton of useful features, including contact forms and automatic plugin updates.
- [Manual Control for JetPack](https://wordpress.org/plugins/manual-control/) prevents JetPack from automatically enabling new features when you update the plugin.
- [Contact Form 7](http://contactform7.com/) is an amazing contact form plugin for WordPress.
- [SMTP Postman](https://wordpress.org/plugins/postman-smtp/) ensures that your contact form emails actually make it to your inbox.
- [WooCommerce](https://wordpress.org/plugins/woocommerce/) is robust ecommerce plugin that makes it easier to supplement your donation revenue with earned income.
- [VaultPress](https://vaultpress.com/) provides simple, automated backups from the folks who built WordPress.
- [ZenCache](https://wordpress.org/plugins/zencache/) makes your website load a lot faster.

### Web Hosting

#### If you have no in-house web/digital team and no idea what you're doing...

[GoDaddy's Managed WordPress hosting](https://www.godaddy.com/pro/managed-wordpress-hosting) is inexpensive, easy to use, and comes with great customer support. There's a lot to hate about GoDaddy (from their sexist advertising to their elephant-hunting CEO), but if you want cheap, reliable hosting with some nice security features built in, they're hard to beat.

#### If you have a web/digital team and want something better...

I cannot say enough great things about [DigitalOcean](https://m.do.co/c/08a079d9bd9a). Their plans start at just $5 a month and all of the sites I host with them are lightning fast. [Use my referral link](https://m.do.co/c/08a079d9bd9a) and you'll get a free $10 credit.

I use [ServerPilot](https://serverpilot.io/) with DigitalOcean. ServerPilot automates a lot of the "getting setup" stuff involved in working with DigitalOcean.

For domain registration, I like [Namecheap](https://www.namecheap.com/). They're inexpensive and really easy to work with.