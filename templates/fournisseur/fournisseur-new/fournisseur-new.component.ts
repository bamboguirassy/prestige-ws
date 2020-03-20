import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Fournisseur } from '../fournisseur';
import { FournisseurService } from '../fournisseur.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-fournisseur-new',
  templateUrl: './fournisseur-new.component.html',
  styleUrls: ['./fournisseur-new.component.css'],
  providers: [DialogService]
})
export class FournisseurNewComponent extends BamboAbstractNewComponent<Fournisseur> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fournisseurSrv: FournisseurService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, fournisseurSrv, connectionService);
    this.item = new Fournisseur();
  }

  ngOnInit() {}

  prepareCreation() {}

}
