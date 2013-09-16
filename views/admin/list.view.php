<style type="text/css">
    .task_manager h1 {
        margin-bottom: 0.5em;
    }
</style>
<div class="task_manager page line ui-widget" id="<?= $div_id = uniqid('taskmanager_') ?>">
    <div class="col c1"></div>
    <div class="col c10" style="position:relative;">
        <h1 class="title"><?= e(__('Tasks list')) ?></h1>
        <table class="tasks_list">
            <thead>
                <tr>
                    <td>
                        <?= e(__('Task')) ?>
                    </td>
                    <td>
                        <?= e(__('Link')) ?>
                    </td>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($tasks as $module => $module_tasks) {
    ?>
                <tr class="module_name" data-type="module_name">
                    <td>
                        <h3>
                            <?= e($module) ?>
                        </h3>
                    </td>
                    <td>

                    </td>
                </tr>
    <?php
    foreach ($module_tasks as $task) {
        echo render('noviusos_taskmanager::admin/item', array('task' => $task));
    }
}
?>
            </tbody>
        </table>
    </div>
    <div class="col c1"></div>
</div>

<script type="text/javascript">
    require(
        [
            'jquery-nos',
            'wijmo.wijtabs',
            'wijmo.wijgrid'
            /*'static/apps/noviusos_appwizard/js/jquery.appwizard.js',
            'link!static/apps/noviusos_appwizard/css/appwizard.css'*/
        ],
        function($) {
            var $div = $('#<?= $div_id ?>');
            $div.nosTabs('update', {
                label: <?= \Format::forge(__('‘Build your app’ wizard'))->to_json() ?>,
                url:  'admin/noviusos_taskmanager/application',
                iconUrl: 'static/apps/noviusos_taskmanager/img/task-32.png',
                app: true,
                iconSize: 32,
                labelDisplay: false
            });

            $div.find('table.tasks_list').wijgrid({
                rendered: function(args) {
                    var $table = $(args.target);
                    $table.find('tbody tr h3').each (function() {
                        var $this = $(this);
                        $this.closest('td').css({
                            borderRight: 0
                        })
                    });
                    //$(args.target).closest('.wijmo-wijgrid').find('thead').hide();
                },
                selectionMode: 'none',
                highlightCurrentCell: false
            });
        }
    );
</script>