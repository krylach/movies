{include file="{$template_dir}crud/header.{$suffix_template}.tpl"}
<div class="row flex-lg-nowrap">
   <div class="col mb-6">
      <div class="e-panel card">
         <div class="card-body">
            <div class="card-title">
               <h6 class="mr-2"><span>{$movie->title} movie edit:</span></h6>
            </div>
            <div class="e-table">
                <form class="form my-5" method="post" action="/admin/movie/{$movie->id}/edit">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title" value="{$movie->title}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Realese year</label>
                                        <input class="form-control" type="number" value="{$movie->release_year}" min="1900" max="2024" name="release_year" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Format</label>
                                        <select class="form-control" name="format_id" required>
                                            {foreach $formats as $format}
                                                <option value="{$format->id}" {if ($movie->format_id === $format->id)} selected {/if}>
                                                    {$format->name}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <label>Stars</label>
                                        <select class="form-control" name="stars[]" multiple require size="12">
                                            {foreach $stars as $star}
                                                <option value="{$star->id}" {if (in_array($star->id, pluck($movie->stars(), 'id')))} selected {/if}>
                                                    {$star->name}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <a class="btn" href="/admin/movies">Back to list</a>
                            <button class="btn btn-primary" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
         </div>
      </div>
   </div>
</div>
{include file="{$template_dir}crud/footer.{$suffix_template}.tpl"}