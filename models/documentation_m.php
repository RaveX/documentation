<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation_m extends MY_Model
{

	public function get_directory()
	{

		// Variables
		$dir = FALSE;

		// Get addon path
		if( file_exists(SHARED_ADDONPATH . 'modules/documentation/details.php') )
		{
			$dir = FCPATH.'addons/shared_addons/modules/';
		}
		else
		{
			$dir = FCPATH.'addons/'.SITE_REF.'/modules/';
		}

		// Check dir
		if( $dir )
		{
			$dir .= 'documentation/docs/';
			$dir .= ( file_exists($dir.CURRENT_LANGUAGE.'/.data') ? CURRENT_LANGUAGE : AUTO_LANGUAGE ).'/';
		}

		// Return
		return $dir;
	}

	public function generate_doc_tree($data)
	{
	
		// Variables
		$tmp  = array();
		$tree = array();
			
		// Start building
		foreach( $data AS $doc )
		{
			$tmp[$doc['id']] = $doc;
		}
		
		unset($data);

		foreach( $tmp as $row )
		{
	
			if( array_key_exists($row['parent'], $tmp) )
			{
				$tmp[$row['parent']]['children'][] =& $tmp[$row['id']];
			}
	
			if ($row['parent'] == 0)
			{
				$tree[] =& $tmp[$row['id']];
			}
	
		}
		
		// Return
		return $tree;
	}

	public function tree_builder($doc, $tree = '', $first = true)
	{

		// Variables
		if( isset($doc['children']) )
		{

			foreach($doc['children'] as $doc)
			{

				$tree .= '<li id="doc_' . $doc['id'] . '">' . "\n";
				$tree .= '  <div>' . "\n";
				$tree .= '    <a href="documentation/' . $doc['slug'] . '" rel="' . $doc['id'] . '">' . $doc['title'] . '</a>' . "\n";
				$tree .= '  </div>' . "\n";

				if( isset($doc['children']) )
				{

					$tree .= '  <ul>' . "\n";
					$tree  = $this->tree_builder($doc, $tree, false);
					$tree .= '  </ul>' . "\n";
					$tree .= '</li>' . "\n";
				}

				$tree .= '</li>' . "\n";
			}

		}

		// Return or echo
		if( !$first )
		{
			return $tree;
		}	
		else
		{
			echo $tree;
		}

	}

	public function set_children($doc, $keys, &$docs)
	{
		if( isset($doc['children']) )
		{
			foreach( $doc['children'] as $i => $child )
			{

				// Variables
				$id     = str_replace('doc_', '', $child['id']);
				$parent = str_replace('doc_', '', $doc['id']);
				$key    = $keys[$id];
				
				// Check parent
				if( $id != $parent )
				{
					// Update order
					$docs[$key]['order']  = $i;
					$docs[$key]['parent'] = $parent;
				}
				
				//repeat as long as there are children
				if( isset($child['children']) )
				{
					$this->set_children($child, $keys, $docs);
				}

			}
		}
	}

}