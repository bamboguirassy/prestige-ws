import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { FournisseurService } from '../fournisseur.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Fournisseur } from '../fournisseur';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './fournisseur-edit.component.html',
  styleUrls: ['./fournisseur-edit.component.css']
})
export class FournisseurEditComponent extends BamboAbstractEditComponent<Fournisseur> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fournisseurSrv: FournisseurService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, fournisseurSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
