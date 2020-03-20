import { Component, OnInit, OnDestroy } from '@angular/core';
import { Fournisseur } from '../fournisseur';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { FournisseurService } from '../fournisseur.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './fournisseur-show.component.html',
  styleUrls: ['./fournisseur-show.component.css']
})
export class FournisseurShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Fournisseur;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fournisseurSrv: FournisseurService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, fournisseurSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


