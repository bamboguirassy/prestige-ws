import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Modele } from '../modele';
import { ModeleService } from '../modele.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-modele-new',
  templateUrl: './modele-new.component.html',
  styleUrls: ['./modele-new.component.css'],
  providers: [DialogService]
})
export class ModeleNewComponent extends BamboAbstractNewComponent<Modele> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public modeleSrv: ModeleService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, modeleSrv, connectionService);
    this.item = new Modele();
  }

  ngOnInit() {}

  prepareCreation() {}

}
