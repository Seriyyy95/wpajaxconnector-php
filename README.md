## WPAjaxConnector-PHP

This package can be used to interact with wpajaxconnector-plugin using PHP. 
It implements all methods that the plugin supports. To install the package first add the repository to your `composer.json`:

```json

```

Then use run the following composer command:

```bash
composer require seriyyy95/wpajaxconnector-php
```

Here are some examples:

```php
$domain = "https://example.com";
$accessKey = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$connector = new \WPAjaxConnector\WPAjaxConnectorPHP\WPConnector($domain, $accessKey);

//Get posts list
$posts = $connector->query()->getPosts();

//Get attachment list
$attachments = $connector->query()->getAttachments();

//Get attachments for a specific post

$attachments = $connector->query()->parent(999)->getAttachments();

//Get gutenberg blocks for post

$blocks = $connector->getPostBlocks(999);

//Get all available data for post
$data = $connector->getPost(999);
```
