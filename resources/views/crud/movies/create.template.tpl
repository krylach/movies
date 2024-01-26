<div class="modal fade" role="dialog" tabindex="-1" id="user-form-modal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create {$title}</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="py-1">
					<form class="form" method="post" action="/admin/movies/create">
						<div class="row">
							<div class="col">
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label>Title</label>
											<input class="form-control" type="text" name="title" required>
                                            <span class="error">
                                                {if isset($errors['title'])}
                                                    {$errors['title']}
                                                {/if}
                                            </span>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label>Realese year</label>
											<input class="form-control" type="number" min="1900" max="2024" name="release_year" required>
                                            <span class="error">
                                                {if isset($errors['release_year'])}
                                                    {$errors['release_year']}
                                                {/if}
                                            </span>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label>Format</label>
											<select class="form-control" name="format_id" required>
                                                {foreach $formats as $format}
                                                    <option value="{$format->id}">
                                                        {$format->name}
                                                    </option>
                                                {/foreach}
                                            </select>
                                            <span class="error">
                                                {if isset($errors['format_id'])}
                                                    {$errors['format_id']}
                                                {/if}
                                            </span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col mb-3">
										<div class="form-group">
											<label>Stars</label>
											<select class="form-control" name="stars[]" multiple required>
                                                {foreach $stars as $star}
                                                    <option value="{$star->id}">
                                                        {$star->name}
                                                    </option>
                                                {/foreach}
                                            </select>
                                            <span class="error">
                                                {if isset($errors['stars'])}
                                                    {$errors['stars']}
                                                {/if}
                                            </span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
						<div class="row">
							<div class="col d-flex justify-content-end">
								<button class="btn btn-primary" type="submit">Create</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>