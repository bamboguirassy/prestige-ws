<div class="row">
    <div class="col-sm-9 col-md-10">
        <p-tabView>
            <p-tabPanel header="Détails">
                <div class="row">
                    <div class="col-sm-12">
                        <p-card [header]="item?.id">
                            <table class="table table-striped table-responsive table-condensed table-hover">
                                <?php foreach ($entity_fields as $field): ?>
                                    <?php if ($field['fieldName'] != 'id') { ?>
                                        <tr>
                                            <th><?= ucfirst($field['fieldName']) ?></th>
                                            <td>{{ <?= 'item?.' . $field['fieldName'] ?> }}</td>
                                        </tr>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </table>
                        </p-card>
                    </div>
                </div>
            </p-tabPanel>
            <p-tabPanel header=".">
                
            </p-tabPanel>
        </p-tabView>
    </div>
    <div class="col-sm-3 col-md-2 mt-sm-2">
        <div class="ui-fluid">
            <div class="ui-g-12">
                <button (click)="close()" pButton type="button" label="Fermer" icon="pi pi-times">
                    </button>
                <button *ngIf="(resourceName|showable) && !isOffline" (click)="refresh()" pButton type="button" label="Raffraichir"
                    icon="pi pi-refresh" style="margin-right: 3px; margin-bottom: 0px;"
                    class="ui-button-raised ui-button-rounded btn-block ui-button-secondary mt-1"></button>
            </div>
        </div>
    </div>
</div>