<?php

/**
 * Copyright © 2017 FinalBit Solution. All rights reserved.
 * http://www.finalbit.ch
 * See LICENSE.txt for license details.
 */

/*
 * This file can be called using a cron to generate Google Sitemap files automatically
 */

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
/* Check to security tocken */
if (substr(Tools::encrypt('gsitemap/cron'), 0, 10) != Tools::getValue('token') || !Module::isInstalled('gsitemap'))
	die('Bad token');

$gsitemap = Module::getInstanceByName('gsitemap');
/* Check if the module is enabled */
if ($gsitemap->active)
{
	/* Check if the requested shop exists */
	$shops = Db::getInstance()->ExecuteS('SELECT id_shop FROM `'._DB_PREFIX_.'shop`');
	$list_id_shop = array();
	foreach ($shops as $shop)
		$list_id_shop[] = (int)$shop['id_shop'];

	$id_shop = (isset($_GET['id_shop']) && in_array($_GET['id_shop'], $list_id_shop)) ? (int)$_GET['id_shop'] : (int)Configuration::get('PS_SHOP_DEFAULT');
	$gsitemap->cron = true;
	
	/* for the main run initiat the sitemap's files name stored in the database */
	if (!isset($_GET['continue']))
		$gsitemap->emptySitemap((int)$id_shop);

	/* Create the Google Sitemap's files */
	p($gsitemap->createSitemap((int)$id_shop));
	
} 
