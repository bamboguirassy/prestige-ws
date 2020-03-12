import { Component, OnInit, OnDestroy } from '@angular/core';
import { Entreprise } from '../entreprise';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { EntrepriseService } from '../entreprise.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './entreprise-show.component.html',
  styleUrls: ['./entreprise-show.component.css']
})
export class EntrepriseShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Entreprise;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public entrepriseSrv: EntrepriseService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, entrepriseSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


