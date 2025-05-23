# 🚚 WooCommerce Custom Delivery & Pickup Fields

This child theme adds enhanced delivery and pickup options to the WooCommerce checkout page, giving your customers more flexibility and control over their order preferences.

---

## ✨ Features

- **Delivery Type Selector**: Choose between Delivery or Pickup.
- **Dynamic Fields Based on Delivery Type**:
  - **Delivery**: Shows Delivery Address, Delivery Area, Delivery Village.
  - **Pickup**: Shows Pickup Location and Pickup Date.
- **Flexible Pickup Location Management**.
- **Lightweight & Easy to Customize**.

---

## 🧰 Installation

1. You need Woodmart Theme for this to work
2. Download the child theme and activate

---

## ⚙️ Code Overview

### ✅ Fields Added to Checkout

| Field            | Type   | Shown When `Delivery Type` is | Required |
| ---------------- | ------ | ----------------------------- | -------- |
| Delivery Type    | Select | Always                        | Yes      |
| Delivery Address | Text   | Delivery                      | Yes      |
| Delivery Area    | Text   | Delivery                      | Yes      |
| Delivery Village | Text   | Delivery                      | Yes      |
| Pickup Location  | Select | Pickup                        | Yes      |
| Pickup Date      | Date   | Pickup                        | Yes      |

---

## How to Edit Code from the WordPress Dashboard

To make changes to your theme’s code directly from the WordPress Dashboard, follow these steps:

1. Log in to your WordPress admin panel.
2. From the left sidebar, go to **Appearance** > **Theme File Editor**.
3. You will see a list of theme files on the right side (e.g., `functions.php`, `style.css`, files inside `includes/`, etc.).
4. Click on the file you want to edit — the code will appear in the editor in the center.
5. Make your changes and click the **Update File** button to save.

> ⚠️ **Important:**
>
> - Be cautious when editing code directly — a small mistake can break your site.
> - Always back up your theme files before making any changes.
> - It’s recommended to use a child theme for custom modifications to avoid losing changes during theme updates.

## 🧩 Add New Pickup Locations

You can easily add or update pickup locations by modifying the `pickup_location` field options in the code.
You need to go to add_checkout_fields.php

### 🧠 Sample Code:

```php
 // Add pickup location field
    $fields['billing']['pickup_location'] = array(
        'type'      => 'select',
        'label'     => __('Pickup Location', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'pickup-field'),
        'clear'     => true,
        'options'   => array(
            'not_selected' => __('Select a Pickup Location', 'woocommerce'),
            'small-business-hub-kitty'   => __( 'Small Business Hub - Kitty', 'woocommerce'),
            'others'               => __('Others','woocommerce')
            // Add more pickup locations as needed
            // 'location_1' => __('Location 1', 'woocommerce'),
        )
    );
```

## 🧩 Add New Area

You can easily add or update pickup locations by modifying the `delivery_area` field options in the code.
You need to go to add_checkout_fields.php

### 🧠 Sample Code:

```php
  // Add delivery area field with options
    // This field will be used to determine the village options available
    // and will be populated via AJAX based on the selected area
    $fields['billing']['delivery_area'] = array(
        'type'      => 'select',
        'label'     => __('Area', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'delivery-field'),
        'clear'     => true,
        'options'   => array(
            'not_selected'                    => __('Select an Area', 'woocommerce'),
            'georgetown'         => __('Georgetown', 'woocommerce'),
            'east_coast'         => __('East Coast Demerara', 'woocommerce'),
            'east_bank'          => __('East Bank Demerara', 'woocommerce'),
            'west_coast'         => __('West Coast Demerara', 'woocommerce'),
            'west_bank'          => __('West Bank Demerara', 'woocommerce')
            // Add more areas as needed
            // 'area_1' => __('Area 1', 'woocommerce'),
        )
    );
```

## 🧩 Add New Village

You can easily add or update village by modifying the `$villages` array in the code.
You need to go to checkout-field-village-data.php

### 🧠 Sample Code:

```php
switch($area) {
        case 'georgetown':
            $villages = array(
                'north_south_cumminsburg' => 'North/South Cumminsburg',
                'regent_street' => 'Regent Street',
                'robb_street' => 'Robb Street',
                'charlotte_street' => 'Charlotte Street',
                // Add more villages as needed
                // 'villages_1' => 'Village 1',
            );
            break;

    }
```

## 🧩 Add Shipping or Delivery fee

You can easily add or update Shipping or Delivery fee by modifying the `$special_shipping_village` array in the code.
You need to go to checkout_shipping_fee.php

### 🧠 Sample Code:

```php
$special_shipping_villages = array(

    // West Bank Demerara (WBD)
    'farm_wbd' => 5000,
    'pouderoyen' => 2000,
    // Add more Shipping or Delivery fee ass needed
    // 'dhaka' => 5000,

)
```

## If you open the code file you will understand it better, it is well documented there.
