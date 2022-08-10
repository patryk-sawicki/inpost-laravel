# InPost ShipX API Client

InPost ShipX API client for laravel.

Based on aPaczka api [doc](https://dokumentacja-inpost.atlassian.net/wiki/spaces/PL/pages/622754/API+ShipX).

## Requirements

* PHP 7.4 or higher with json extensions.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
$ composer require patryk-sawicki/inpost
```

## Usage

Import class.

```php
use PatrykSawicki\InPost\app\Classes\InPost;
```

### Organizations

#### List

Get organizations list.

```php
InPost::organizations()->list(array $options = [], bool $returnJson = false);
```

#### Get

Get organizations details.

```php
InPost::organizations()->get(int $id, bool $returnJson = false);
```

#### Statistics

Get organizations statistics.

```php
InPost::organizations()->statistics(int $id, bool $returnJson = false);
```

### Services

Get a list of the available services.

```php
InPost::services()->list(bool $returnJson = false);
```

### Points

#### List

Get a list of the available points.

```php
InPost::points()->list(array $options = [], bool $returnJson = false);
```

#### Get

Get a point details.

```php
InPost::points()->get(string $name, bool $returnJson = false);
```

### Shipment

#### Send

Send a new shipment.

```php
use PatrykSawicki\InPost\app\Classes\InPost;
use PatrykSawicki\InPost\app\Models\Cash as InPostCash;
use PatrykSawicki\InPost\app\Models\Dimensions as InPostDimensions;
use PatrykSawicki\InPost\app\Models\Weight as InPostWeight;
use PatrykSawicki\InPost\app\Models\Address as InPostAddress;
use PatrykSawicki\InPost\app\Models\Parcel as InPostParcel;
use PatrykSawicki\InPost\app\Models\Parcels as InPostParcels;
use PatrykSawicki\InPost\app\Models\Receiver as InPostReceiver;
use PatrykSawicki\InPost\app\Models\Sender as InPostSender;

$shipment = InPost::shipment();

/*Set organization*/
$shipment->setOrganizationId(123);

/*Receiver*/
$receiverAddress = new InPostAddress('street', 'building_number', 'city', 'post_code', 'PL');
$receiver = new InPostReceiver('name', 'company name', 'first name', 'last name', 'e-mail', 'phone', $receiverAddress);
$shipment->setReceiver($receiver);

/*Sender - Optional*/
$senderAddress = new InPostAddress('street', 'building_number', 'city', 'post_code', 'PL');
$sender = new InPostSender('name', 'company name', 'first name', 'last name', 'e-mail', 'phone', $senderAddress);
$shipment->setSender($sender);

/*Parcels*/
$dimensions = new InPostDimensions(10, 10, 10, 'mm');
$weight = new InPostWeight(10, 'kg');
$firstParcel = new InPostParcel($dimensions, $weight, 'parcel 1');

/*Second parcel is optional.*/
$dimensions = new InPostDimensions(20, 20, 20, 'mm');
$weight = new InPostWeight(5, 'kg');
$secondParcel = new InPostParcel($dimensions, $weight, 'parcel 2');

$shipment->setParcels(new InPostParcels($firstParcel, $secondParcel));

/*Insurance - Optional*/
$insurance = new InPostCash(100, 'PLN');
$shipment->setInsurance($insurance);

/*Cod - Optional*/
$cod = new InPostCash(100, 'PLN');
$shipment->setCod($cod);

/*Additional Services - Optional*/
$shipment->setAdditionalServices(['sms', 'email']);

/*Reference - Optional*/
$shipment->setReference('reference');

/*Comments - Optional*/
$shipment->setComments('comments');

/*External customer id - Optional*/
$shipment->setExternalCustomerId('external customer id');

/*MPK - Optional*/
$shipment->setMpk('mpk');

/*Is return - Optional*/
$shipment->setIsReturn(false);

/*Service*/
$shipment->setService('inpost_locker_standard');

/*Custom attributes - Optional*/
$shipment->setCustomAttributes(['target_point' => 'xxx']);

/*Only choice of offer - Optional*/
$shipment->setOnlyChoiceOfOffer(true);

/*Send shipment*/
$shipment->send(bool $returnJson = false);
```

#### Cancel

Cancellation of a shipment.

```php
InPost::shipment()->cancel(int $id, bool $returnJson = false);
```

#### Label

Get label for a shipment.

```php
return InPost::shipment()->label(int $id, string $format = 'pdf', string $type = 'normal');
```

### Tracking

Get a tracking details.

```php
InPost::tracking()->get(string $tracking_number, bool $returnJson = false);
```

### Statuses

Get a list of the available statuses.

```php
InPost::statuses()->list(bool $returnJson = false);
```

### Dispatch orders

#### Create

Create a new dispatch orders.

```php
use PatrykSawicki\InPost\app\Classes\InPost;
use PatrykSawicki\InPost\app\Models\Address as InPostAddress;

$dispatchOrders = InPost::dispatchOrders();

/*Set organization*/
$dispatchOrders->setOrganizationId(2324);

/*Set shipments*/
$dispatchOrders->setShipments(1, 2, 3, 4);

/*Set comments - Optional*/
$dispatchOrders->setComments('Test');

/*Set address*/
$dispatchOrders->setAddress(new InPostAddress('street', 'building_number', 'city', 'post_code', 'PL'));

/*Set office hours - Optional*/
$dispatchOrders->setOfficeHours('09:00 - 18:00');

/*Set name*/
$dispatchOrders->setName('Patryk Sawicki');

/*Set phone*/
$dispatchOrders->setPhone('+48793202257');

/*Set email - Optional*/
$dispatchOrders->setEmail('patryk@patryksawicki.pl');

/*Create a new dispatch orders.*/
$dispatchOrders->create(bool $returnJson = false);
```

#### Cancel

Cancellation of a dispatch orders

```php
InPost::dispatchOrders()->cancel(int $id, bool $returnJson = false);
```

#### List

Get dispatch orders list.

```php
$dispatchOrders = InPost::dispatchOrders();

/*Set organization*/
$dispatchOrders->setOrganizationId(2324);


$dispatchOrders->list(bool $returnJson = false);
```

#### Get

Get dispatch orders details.

```php
$dispatchOrders->get(int $id, bool $returnJson = false);
```

#### Add comment

Add comment to dispatch orders.

```php
$dispatchOrders = InPost::dispatchOrders();

/*Set organization*/
$dispatchOrders->setOrganizationId(123456);

$dispatchOrders->addComment(int $dispatch_order_id, string $comment, bool $returnJson = false);
```

#### Update comment

Update comment in dispatch orders.

```php
$dispatchOrders = InPost::dispatchOrders();

/*Set organization*/
$dispatchOrders->setOrganizationId(123456);

$dispatchOrders->updateComment(int $dispatch_order_id, int $comment_id, string $comment, bool $returnJson = false);
```

#### Update comment

Update comment in dispatch orders.

```php
$dispatchOrders = InPost::dispatchOrders();

/*Set organization*/
$dispatchOrders->setOrganizationId(123456);

$dispatchOrders->removeComment(int $dispatch_order_id, int $comment_id, bool $returnJson = false);
```

## Changelog

Changelog is available [here](CHANGELOG.md).
