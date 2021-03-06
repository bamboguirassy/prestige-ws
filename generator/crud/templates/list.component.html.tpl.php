<ng-container *ngIf="!isLoading; else loadingContent">
    <!-- *ngIf="resourceName|listable" -->
    <p-table #tt [value]="items" [autoLayout]="true" [paginator]="true"
        [rows]="itemPerPage" sortMode="multiple" [globalFilterFields]="columns" [(selection)]="selectedItems"
        dataKey="id" [responsive]="true" paginatorPosition="both" (onEditComplete)="updateItem($event)" [(contextMenuSelection)]="selectedItem"
        [contextMenu]="cm">
        <ng-template pTemplate="caption">
            Liste des <?= $entity_var_plural ?>
            <hr class="mt-1">
            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" size="30" placeholder=" Recherche globale"
                                (input)="tt.filterGlobal($event.target.value, 'contains')"
                                style="width:auto; border-left:0">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="pi pi-search" style="margin:4px 4px 0 0"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <button *ngIf="resourceName|deletable" [disabled]="isOffline" (click)="removeSelecteditem()"
                            pButton type="button" label="Supprimer" icon="pi pi-times"
                            class="ui-button-danger float-lg-right mr-1 ml-1 mt-1"></button>
                        <button *ngIf="resourceName|creable" [disabled]="isOffline" (click)="openNewFormDialog()"
                            pButton type="button" label="Nouveau" class="float-lg-right mt-1 ml-1"
                            icon="pi pi-plus"></button>
                        <button *ngIf="(resourceName|listable)" [disabled]="isOffline" (click)="findAll()" pButton
                            type="button" label="Raffraichir" icon="pi pi-refresh"
                            class="ui-button-raised ui-button-rounded ui-button-secondary float-lg-right mt-1 ml-1"></button>
                    </div>
                </div>
            </div>
            <hr>
        </ng-template>
        <ng-template pTemplate="header">
            <tr>
                <th style="width: 2.25em">
            <p-tableHeaderCheckbox></p-tableHeaderCheckbox>
        </th>
        <th>#</th>
        <?php foreach ($entity_fields as $field): ?>
            <?php if ($field['fieldName'] != 'id') { ?>
                <th [pSortableColumn]="'<?= $field['fieldName'] ?>'">
                <p-sortIcon [field]="'<?= $field['fieldName'] ?>'"></p-sortIcon>
                <?= ucfirst($field['fieldName']) ?>
                </th>
            <?php } ?>
        <?php endforeach; ?>
        </tr>
        </ng-template>
        <ng-template pTemplate="body" let-<?= $entity_var_singular ?> let-rowIndex="rowIndex">
            <tr [pSelectableRow]="<?= $entity_var_singular ?>" [pContextMenuRow]="<?= $entity_var_singular ?>">
                <td>
            <p-tableCheckbox [value]="<?= $entity_var_singular ?>" [index]="rowIndex"></p-tableCheckbox>
        </td>
        <td>
            <span class="ui-column-title">#</span>
            {{rowIndex+1}}</td>
        <?php foreach ($entity_fields as $field): ?>
            <?php if ($field['fieldName'] != 'id') { ?>
                <td [pEditableColumn]="<?= $entity_var_singular ?>">
                    <span class="ui-column-title"><?= ucfirst($field['fieldName']) ?></span>
                <p-cellEditor>
                    <ng-template pTemplate="input">
                        <input type="text" [(ngModel)]="<?= $entity_var_singular . '.' . $field['fieldName'] ?>">
                    </ng-template>
                    <ng-template pTemplate="output">
                        {{<?= $entity_var_singular . '?.' . $field['fieldName'] ?>}}
                    </ng-template>
                </p-cellEditor>
                </td>
            <?php } ?>
        <?php endforeach; ?>
        </tr>
        </ng-template>
        <ng-template pTemplate="summary">
            Nombre d'enregistrements : {{items?.length}}
        </ng-template>
    </p-table>

    <p-contextMenu #cm [model]="menuItems" (onShow)="initContextualMenu()"></p-contextMenu>

    <p-confirmDialog #cd header="Confirmation" icon="pi pi-exclamation-triangle">
        <p-footer>
            <button type="button" pButton icon="pi pi-times" label="Annuler" (click)="cd.reject()"></button>
            <button class="ui-button-danger" type="button" pButton icon="pi pi-check" label="Confirmer"
                (click)="cd.accept()"></button>
        </p-footer>
    </p-confirmDialog>

    <p-toast></p-toast>

</ng-container>
<ng-template #loadingContent>
    <ngx-skeleton height="50px" margin="0 0 8px 0"></ngx-skeleton>
    <ngx-skeleton height="70px" margin="0 0 8px 0"></ngx-skeleton>
    <ngx-skeleton height="150px" margin="0 0 8px 0" width="100%"></ngx-skeleton>
    <ngx-skeleton height="50px" margin="0 0 8px 0"></ngx-skeleton>
</ng-template>