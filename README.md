# Mercator Loader
Making uploading and downloading of documents/images easy for [WinterCMS](https://wintercms.com): Just add
a component/snippet to your page and specify where you want the upload to be stored. That's it.
The "dropping part" on the client side is based on [Dropzone](https://www.dropzonejs.com).

## Installation
Use composer to install

```
composer require mercator/wn-loader-plugin
php artisan winter:up
```

## Usage
Place on a CMS or Static Pages page as *component* or *snippet* respectively. There are only a few parameters to 
adjust for the time being:
- *Destination*: Path relative to the storage directory. If the path does not exist, it will be created upon upload.
- *Accepted Exentions*: Extensions (file types) allowed for upload. Format as comma-separated string, e.g. *.jpg,.jpeg,.doc,.docx*. 
Note: When the string is left empty, no restrictions apply.
- *Uplaod File Size Limit*: Maximum size per individual file (in megabytes). Larger files will not be uplaoded.
- *Options*: Additional Dropzone options, comma separated. See [Dropzone](https://www.dropzonejs.com) for the list of options.

You can also modify the component's properties directly when you call the component, just assign vaues to the
component's properties. For example, if you want to upload *images* with a maximum size of *10MB* to */storgae/app/media/myUploads* - and resize the images 100x100,
you would use the following:

```
{% component 'Loader' destinationDirectory=("/app/media/myUploads") acceptedExtensions=".jpg,.jpeg,.webp,.gif,.pbm" uploadSizeLimit=10 options="resizeWidth:100, resizeHeight:100" %}
```
## Future
- Anonymous upload, i.e., uploaded files will be grouped by sessions

## Limitations
The upload currently does not work for Apple's iOS devices. This is a known limitation/bug of the [Dropzone](https://www.dropzonejs.com) library.


