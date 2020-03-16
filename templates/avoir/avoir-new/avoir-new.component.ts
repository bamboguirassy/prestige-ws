import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Avoir } from '../avoir';
import { AvoirService } from '../avoir.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-avoir-new',
  templateUrl: './avoir-new.component.html',
  styleUrls: ['./avoir-new.component.css'],
  providers: [DialogService]
})
export class AvoirNewComponent extends BamboAbstractNewComponent<Avoir> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public avoirSrv: AvoirService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, avoirSrv, connectionService);
    this.item = new Avoir();
  }

  ngOnInit() {}

  prepareCreation() {}

}
