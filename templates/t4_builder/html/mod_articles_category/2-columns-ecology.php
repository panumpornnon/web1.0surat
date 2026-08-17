<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<ul class="blog-list<?php echo $moduleclass_sfx; ?> mod-list blog-list-ecology row">
	<?php if ($grouped) : ?>
		<?php foreach ($list as $group_name => $group) : ?>
		<li>
			<div class="mod-articles-category-group"><?php echo JText::_($group_name); ?></div>
			<ul>
				<?php foreach ($group as $item) : ?>
					<li>
						<?php if ($params->get('link_titles') == 1) : ?>
							<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								<?php echo $item->title; ?>
							</a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>

						<?php if ($item->displayHits) : ?>
							<span class="mod-articles-category-hits">
								(<?php echo $item->displayHits; ?>)
							</span>
						<?php endif; ?>

						<?php if ($params->get('show_author')) : ?>
							<span class="mod-articles-category-writtenby">
								<?php echo $item->displayAuthorName; ?>
							</span>
						<?php endif; ?>

						<?php if ($item->displayCategoryTitle) : ?>
							<span class="mod-articles-category-category">
								(<?php echo $item->displayCategoryTitle; ?>)
							</span>
						<?php endif; ?>

						<?php if ($item->displayDate) : ?>
							<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
						<?php endif; ?>

						<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
							<div class="mod-articles-category-tags">
								<?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
							</div>
						<?php endif; ?>

						<?php if ($params->get('show_introtext')) : ?>
							<p class="mod-articles-category-introtext">
								<?php echo $item->displayIntrotext; ?>
							</p>
						<?php endif; ?>

						<?php if ($params->get('show_readmore')) : ?>
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
									<?php if ($item->params->get('access-view') == false) : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?php echo $readmore; ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php endif; ?>
									<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
										<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
									<?php else : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php endif; ?>
								</a>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	<?php else : ?>
		<?php foreach ($list as $item) : ?>
			<li class="col-12 col-md-6">
				<div class="blog-list-ecology-inner">
	        <!-- Item image -->
	        <?php
	        $images = "";
	        if (isset($item->images)) {
	          $images = json_decode($item->images);
	        }

	        $imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));

	        if ($imgexists) {
	        	$images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
	        ?>

	        <a class="item-image" href="<?php echo $item->link; ?>">
	          <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
	        </a>
	        <?php } ?>
	        <!-- // Item image -->

	        <div class="blog-list-ecology-content">
						<?php if ($item->displayCategoryTitle) : ?>
							<span class="mod-articles-category-category">
								<?php echo $item->displayCategoryTitle; ?>
							</span>
						<?php endif; ?>

						<?php if ($params->get('link_titles') == 1) : ?>
							<h3 class="item-title"><a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
						<?php else : ?>
							<h3><?php echo $item->title; ?></h3>
						<?php endif; ?>

		        <div class="article-meta">
							<?php if ($item->displayDate) : ?>
								<span class="item-date">
									<?php echo $item->displayDate; ?>
								</span>
							<?php endif; ?>

							<?php if ($item->displayHits) : ?>
								<span class="mod-articles-category-hits">
									<i class="fa fa-eye" aria-hidden="true"></i><?php echo $item->displayHits; ?>
								</span>
							<?php endif; ?>
						</div>

						<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
							<div class="mod-articles-category-tags">
								<?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
							</div>
						<?php endif; ?>

						<?php if ($params->get('show_introtext')) : ?>
							<p class="item-introtext">
								<?php echo $item->displayIntrotext; ?>
							</p>
						<?php endif; ?>

						<?php if ($params->get('show_readmore')) : ?>
							<div class="t4b-cta cta-rounded item-readmore">
								<a href="<?php echo $item->link; ?>" class="t4b-link btn btn-readmore gjs-selected">
									<i class="fas fa-angle-right"></i>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<style>
	.blog-list {
		list-style: none;
		margin-bottom: 0;
		padding: 0;
	}

	.blog-list > .col-12 {
		margin-bottom: 30px;
	}

	.blog-list > .col-12:nth-child(3n+1) {
		clear: both;
	}

	.blog-list-ecology-inner {
		position: relative;
	}

	.blog-list-ecology-content {
		position: absolute;
		bottom: 0;
		z-index: 1;
		padding: 40px;
		background: linear-gradient(180deg, rgba(0, 0, 0, 0) 44.76%, rgba(0, 0, 0, 0.85) 89.52%);
		border-radius: 0 0 4px 4px;
	}

	/* Item image */
	.item-image {
		display: block;
		margin-bottom: 0;
	}

	.blog-list-ecology .item-image img {
		width: 100%;
		border-radius: 4px;
	}

	/* Meta */
	.article-meta {
		display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 13px;
    color: #9E9E9E;
	}

	/* Item date */
	.item-date {
		display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 13px;
    color: #9E9E9E;
    margin-right: 8px;
    margin-bottom: 1rem;
	}

	/* Category */
	.mod-articles-category-category {
		background: #E4F7FF;
    padding: 2px 8px;
    margin-right: 8px;
	}

	.mod-articles-category-category a {
    color: #26B0EB;
    text-decoration: none;
	}

	.category-link {
		background-color: #26b0eb;
		border-color: #26b0eb;
		text-transform: uppercase;
		font-weight: 600;
		letter-spacing: .5px;
		color: #fff;
		padding: 1.06rem 2.857rem;
		font-size: 1rem;
		line-height: 1.7143;
		border-radius: 4px;
	}

	/* Hits */
	.mod-articles-category-hits i {
		margin-right: 3px;
	}

	/* Item title */
	.blog-list-ecology .item-title {
		font-family: "Bebas Neue";
		font-style: normal;
		font-weight: normal;
		font-size: 24px;
		line-height: 1.33;
		color: #FFFFFF;
		margin-bottom: 8px;
	}

	.blog-list .item-title a {
		color: #FFFFFF;
		text-decoration: none;
	}

	.blog-list .item-title a:hover,
	.blog-list .item-title a:focus,
	.blog-list .item-title a:active {
		color: #c96d50;
	}

	/* Intro text */
	.item-introtext {
		color: #fff;
		opacity: 0.5;
	}

	/* Read more */
	.blog-list .item-readmore {
		margin-bottom: 0;
	}

	.blog-list .item-readmore a.btn-readmore {
		font-weight: 600;
		border: 0;
		background: #fff;
		color: #009A4E;
	}

	.blog-list .item-readmore a.btn-readmore:hover {
		background: #009A4E;
		color: #fff;
	}

	.blog-list .item-readmore a i{
		line-height: 1;
	}
</style>