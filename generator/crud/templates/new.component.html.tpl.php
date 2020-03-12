<div class="card" *ngIf="resourceName|creable">
    <h1 class="mb-0">Formulaire de création - <?= $entity_class_name ?></h1>
    <hr class="mb-0">
    <form #<?= $entity_var_singular ?>Form="ngForm" (ngSubmit)="createItem()">
        <div class="card-body">
            <div class="row">
                <?php foreach ($entity_fields as $field): ?>
                    <?php if ($field['fieldName'] != 'id') { ?>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="<?= $field['fieldName'] ?>"><?= ucfirst($field['fieldName']) ?></label>
                        <input [(ngModel)]="<?= 'item.' . $field['fieldName'] ?>" type="text" name="<?= $field['fieldName'] ?>" id="<?= $field['fieldName'] ?>" class="form-control"
                                    placeholder="" aria-describedby="help<?= ucfirst($field['fieldName']) ?>Id">
                        <small id="help<?= ucfirst($field['fieldName']) ?>Id" class="text-muted">Ex: </small>
                    </div>
                </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card-footer">
            <button icon="pi pi-times" pButton [disabled]="isSubmitted" label="Fermer" (click)="close()" type="button"
                class="ui-button-raised ui-button-rounded ui-button-secondary mt-1"></button>
            <button [disabled]="isSubmitted" pButton type="reset" label="Vider"
                icon="pi pi-refresh" class="ui-button-info mt-1 ml-1"></button>
            <button *ngIf="resourceName|creable" icon="pi pi-plus b" pButton [disabled]="isSubmitted || <?= $entity_var_singular ?>Form.invalid || isOffline" type="submit"
                class="float-md-right ml-1 mt-1" label="Ajouter">
                <i *ngIf="isSubmitted" class="pi pi-spin pi-spinner ml-1" style="font-weight: bold;"></i>
            </button>
        </div>
    </form>
</div>
