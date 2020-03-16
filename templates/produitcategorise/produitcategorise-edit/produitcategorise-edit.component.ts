import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ProduitCategoriseService } from '../produitcategorise.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ProduitCategorise } from '../produitcategorise';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './produitcategorise-edit.component.html',
  styleUrls: ['./produitcategorise-edit.component.css']
})
export class ProduitCategoriseEditComponent extends BamboAbstractEditComponent<ProduitCategorise> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitCategoriseSrv: ProduitCategoriseService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, produitCategoriseSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
