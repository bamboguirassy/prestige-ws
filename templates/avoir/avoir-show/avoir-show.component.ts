import { Component, OnInit, OnDestroy } from '@angular/core';
import { Avoir } from '../avoir';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { AvoirService } from '../avoir.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './avoir-show.component.html',
  styleUrls: ['./avoir-show.component.css']
})
export class AvoirShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Avoir;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public avoirSrv: AvoirService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, avoirSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


