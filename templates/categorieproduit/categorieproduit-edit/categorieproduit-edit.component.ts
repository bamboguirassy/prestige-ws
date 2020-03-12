import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { CategorieProduitService } from '../categorieproduit.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { CategorieProduit } from '../categorieproduit';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './categorieproduit-edit.component.html',
  styleUrls: ['./categorieproduit-edit.component.css']
})
export class CategorieProduitEditComponent extends BamboAbstractEditComponent<CategorieProduit> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public categorieProduitSrv: CategorieProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, categorieProduitSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
