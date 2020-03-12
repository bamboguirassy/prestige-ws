import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Fonctionnalite } from '../fonctionnalite';
import { FonctionnaliteService } from '../fonctionnalite.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-fonctionnalite-new',
  templateUrl: './fonctionnalite-new.component.html',
  styleUrls: ['./fonctionnalite-new.component.css'],
  providers: [DialogService]
})
export class FonctionnaliteNewComponent extends BamboAbstractNewComponent<Fonctionnalite> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fonctionnaliteSrv: FonctionnaliteService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, fonctionnaliteSrv, connectionService);
    this.item = new Fonctionnalite();
  }

  ngOnInit() {}

  prepareCreation() {}

}
