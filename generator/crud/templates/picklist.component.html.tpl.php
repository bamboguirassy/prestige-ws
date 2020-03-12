<ng-container *ngIf="!isLoading; else loadingContent">
    <div class="ui-g ui-fluid">
        <div class="ui-g-12 ui-md-12">
            <div class="input-group mb-3">
                <p-multiSelect dataKey="id" name="<?= $entity_var_plural ?>" [required]="required" [displaySelectedLabel]="true" selectedItemsLabel="{0} éléments selectionné(s)"
                    [options]="items" *ngIf="isMultipleMode()" (onChange)="handleChange()" class="form-control"
                    [(ngModel)]="selectedItems" optionLabel="id" defaultLabel="Choisir" [maxSelectedLabels]="1">
                </p-multiSelect>
                <p-dropdown dataKey="id" [required]="required" [showClear]="true" *ngIf="isSingleMode()" name="<?= $entity_var_singular ?>"
                    class="form-control" [options]="items" (onChange)="handleChange()" [(ngModel)]="selectedItems"
                    optionLabel="id" filterPlaceholder="Selectionner le <?= $entity_var_singular ?>" [filter]="true"></p-dropdown>
                <div class="input-group-append">
                    <span class="input-group-text" *ngIf="createOnMissing && (resourceName|creable) && !isOffline"
                        (click)="openNewFormDialog()">
                        <i class="pi pi-plus" style="margin:4px 4px 0 0"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</ng-container>
<ng-template #loadingContent>
    <ngx-skeleton height="40px" margin="0 0 8px 0"></ngx-skeleton>
</ng-template>