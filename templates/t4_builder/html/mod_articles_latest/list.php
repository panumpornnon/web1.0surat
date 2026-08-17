<?php
/**
 * ------------------------------------------------------------------------
 * JA Spa Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;
$count = count($list);
?>
<div class="view-latest-list<?php echo $params->get ('moduleclass_sfx') ?>">
	<div class="row">
		<?php $i=0; foreach ($list as $item) :  ?>

				<?php if($i==0 || $i==1) :?>
					<div class="col-sm-6">
				<?php endif ;?>
					<?php if($i==0 && json_decode($item->images)->image_intro) :?>
					<div class="intro-image">
						<img src="<?php echo json_decode($item->images)->image_intro; ?>" alt="" />
					</div>
					<?php endif ;?>

					<div class="item-latest" >
						<div class="content-article">
							<div class="wrap-info d-flex">
								<div class="category-name">
									<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)); ?>" ><?php echo $item->category_title?></a>
								</div>

								<div class="date">			
									<?php echo Text::sprintf(HTMLHelper::_('date', $item->publish_up, Text::_('Y.d.m'))); ?>
								</div>
							</div>

							<div class="title-article">
								<h3>
									<a class="heading-link" href="<?php echo $item->link; ?>">
										<?php echo $item->title; ?>
									</a>
								</h3>
							</div>

							<div class="desc-article">
								<?php echo $item->introtext;?>
							</div>
						</div>
					</div>

				<?php if($i==0 || $i==($count-1)) :?>
					</div>
				<?php endif ;?>

		<?php $i++; endforeach; ?>
	</div>
</div>

<style>
@media (min-width: 1200px) {
  .view-latest-list .row {
    margin-left: -60px;
    margin-right: -60px; 
  }

  .view-latest-list .row > div {
    padding-left: 60px;
    padding-right: 60px; 
  } 
}

.view-latest-list .title-article > h3 {
	font-size: 26px;
}

.view-latest-list .title-article .heading-link {
	color: #212C64;
}

.view-latest-list .row > div + div {
  border-left: 1px solid #F4F4F4; 
}

.view-latest-list .item-latest + .item-latest {
  border-top: 1px solid #F4F4F4;
  padding-top: 30px;
  margin-top: 30px; 
}

.view-latest-list .wrap-info {
  font-size: 12px;
  text-transform: uppercase;
  line-height: 1;
  margin-bottom: 0.5rem; 
}

.view-latest-list .wrap-info > div + div {
  border-left: 1px solid #F4F4F4;
  margin-left: 0.5rem;
  padding-left: 0.5rem; 
}

.view-latest-list .intro-image {
  margin-bottom: 30px; 
}

.view-latest-list .category-name a {
  color: #F6376A; 
}

.view-latest-list .category-name a:hover, 
.view-latest-list .category-name a:focus, 
.view-latest-list .category-name a:active {
  color: #f51f58; 
}
</style>