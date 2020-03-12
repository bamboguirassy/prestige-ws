import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ProduitService } from '../produit.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Produit } from '../produit';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './produit-edit.component.html',
  styleUrls: ['./produit-edit.component.css']
})
export class ProduitEditComponent extends BamboAbstractEditComponent<Produit> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitSrv: ProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, produitSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
