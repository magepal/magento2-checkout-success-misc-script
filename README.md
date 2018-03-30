<a href="http://www.magepal.com" ><img src="https://image.ibb.co/dHBkYH/Magepal_logo.png" width="100" align="right" /></a>

## Add Miscellaneous HTML and Scripts to Magento2 Checkout Success Page 


Add miscellaneous HTML and scripts quickly and easily to your Magento2 checkout success page. Also, ideal for testing new styling of your thank your page, adding new static blocks or other customization to your checkout page.

![success page miscellaneous html and scripts](https://image.ibb.co/gZcjAx/Success_Page_Miscellaneous_HTML_and_Scripts_by_magepal.gif)

### Order Variables

- Order ID
- Total
- Sub Total
- Shipping Cost
- Tax
- Coupon Code
- Discount

## Installation

#### Step 1
##### Using Composer (recommended)

```
composer require magepal/magento2-checkout-success-misc-script
```

##### Manually
 * Download the extension
 * Unzip the file
 * Create a folder {Magento 2 root}/app/code/MagePal/CheckoutSuccessMiscScript
 * Copy the content from the unzip folder


#### Step 2 - Enable extension (from {Magento root} folder)
 * php -f bin/magento module:enable --clear-static-content MagePal_CheckoutSuccessMiscScript
 * php -f bin/magento setup:upgrade

#### Step 3 - Configure Checkout Success Miscellaneous Scripts

Log into your Magento 2 Admin, then goto Stores -> Configuration -> MagePal -> Checkout

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-checkout-success-misc-script/issues).

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

© MagePal LLC. | [www.magepal.com](http:/www.magepal.com)

