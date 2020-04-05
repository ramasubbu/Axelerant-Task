<?php
namespace Drupal\custom_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;


/**
 * Provides a resource to get page content type node details in rest api.
 *
 * @RestResource(
 *   id = "custom_api",
 *   label = @Translation("Get Page contents in Rest API"),
 *   uri_paths = {
 *     "canonical" = "/page_json/{siteapikey}/{nid}",
 *   }
 * )
 */
class CustomAPI extends ResourceBase {

  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get($siteapikey, $nid) {
    if (\Drupal::state()->get('siteapikey') == $siteapikey) {
	  $data = [];
      $node =  \Drupal\node\Entity\Node::load($nid);
      if($node && $node->type[0]->target_id == 'page'){
        $data['node'] = $node;
      }
	  else {
		$data['message'] = t('The page is not exist');
	  }
	}
	else {
	  $data['message'] = t('Access denied');	
	}	
	if ($data['message'] != "") {
	  $response = new ResourceResponse($data, 403);
	}
	else {
      $response = new ResourceResponse($data);
	}
	return $response;
  }
}