
	<div class="one_half">
		<section class="title">
			<h4>Pages</h4>
		</section>
		<section class="item">
<?php if( isset($docs) && !empty($docs) ): ?>
			<div id="documentation-sort">
				<ul class="sortable">
					<?php foreach($docs as $doc): ?>
							<li id="doc_<?php echo $doc['id']; ?>">
								<div>
									<a href="#" rel="<?php echo $doc['id']; ?>"><?php echo $doc['title']; ?></a>
								</div>
					<?php if(isset($doc['children'])): ?>
								<ul>
									<?php $controller->documentation_m->tree_builder($doc); ?>
								</ul>
							</li>
					<?php else: ?>
							</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
<?php else: ?>
			<div class="no_data"><?php echo lang('docs:label:no_docs'); ?></div>
<?php endif; ?>
		</section>
	</div>

	<div class="one_half last">
		<section class="title">
			<h4>Edit</h4>
		</section>
		<section class="item">
		</section>
	</div>