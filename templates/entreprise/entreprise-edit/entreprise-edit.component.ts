import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { EntrepriseService } from '../entreprise.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Entreprise } from '../entreprise';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './entreprise-edit.component.html',
  styleUrls: ['./entreprise-edit.component.css']
})
export class EntrepriseEditComponent extends BamboAbstractEditComponent<Entreprise> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public entrepriseSrv: EntrepriseService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, entrepriseSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
