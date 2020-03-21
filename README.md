# axelarant_dev_drupal_test
Module to provides a route for nodes of content type "page", which gives json response of the node with respect to nid in url

# steps to install
1. clone or download this git repo
2. copy this folder to modules/custom/ folder
3. install the module "axelerant site info" from drupal administration "/admin/modules/" or using drupal console command "drupal moi axelerant_site_info"
4. create nodes of content type basic page
5. Browse to site information page "admin/config/system/site-information", add "Site Api Key"
6. browse to "base_url/page_json/{siteapikey}/{nid}


# List of resources used
1. https://www.drupal.org/docs/8/api/routing-system/access-checking-on-routes
2. https://www.drupal.org/docs/8/api/state-api/overview

# Total time to complete task
2 hrs
