<div class="row flex-lg-nowrap">
   <div class="col mb-3">
      <div class="e-panel card">
         <div class="card-body">
            <div class="card-title">
               <h6 class="mr-2"><span>{$title}</span></h6>
               {if $success}
                <div class="alert alert-success" role="alert">
                    {$success}
                </div>
                {/if}
            </div>
            <div class="e-table">
               <div class="table-responsive table-lg mt-3">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th class="max-width">Name</th>
                           <th class="sortable">Year of issue</th>
                           <th class="sortable">Format</th>
                           <th>Actors</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        {if $movies}
                            {foreach $movies as $movie}
                                <tr>
                                    <td class="text-nowrap align-middle">{$movie->title}</td>
                                    <td class="text-nowrap align-middle"><span>{$movie->release_year}</span></td>
                                    <td class="text-nowrap align-middle"><span>{$movie->format()->name}</span></td>
                                    <td class="text-nowrap align-middle"><span>{mb_strimwidth(implode(', ', pluck($movie->stars(), 'name')), 0, 30, '...')}</span></td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group align-top">
                                            <a href="/admin/movie/{$movie->id}/edit" class="btn btn-sm btn-outline-secondary badge">Edit</a>
                                            <form method="post" action="/admin/movie/{$movie->id}/delete" class="btn btn-sm btn-outline-secondary badge delete-movie">
                                                <button class="btn btn-sm btn-outline-secondary badge" style="border:0;" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-12 col-lg-3 mb-3">
      <div class="card">
         <div class="card-body">
            <div class="text-center px-xl-3">
               <button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#user-form-modal">New {$title}</button>
            </div>
            <hr class="my-3">
            <div class="text-center px-xs-3">
                <div class="mb-3 text-left">
                    <form action="/admin/movies/import" method="post"  enctype="multipart/form-data">
                        <label for="formFile" class="form-label">Import from file</label>
                        <input class="form-control" name="import_file" type="file" id="formFile">
                        <button class="btn btn-success btn-block mt-2" type="submit">Import</button>
                    </form>
                </div>
            </div>
            <hr class="my-3">
            {include file="{$template_dir}crud/movies/filter.{$suffix_template}.tpl"}
         </div>
      </div>
   </div>
</div>
{include file="{$template_dir}crud/movies/create.{$suffix_template}.tpl"}