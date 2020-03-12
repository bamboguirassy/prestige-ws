import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Entreprise } from '../entreprise';
import { EntrepriseService } from '../entreprise.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-entreprise-new',
  templateUrl: './entreprise-new.component.html',
  styleUrls: ['./entreprise-new.component.css'],
  providers: [DialogService]
})
export class EntrepriseNewComponent extends BamboAbstractNewComponent<Entreprise> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public entrepriseSrv: EntrepriseService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, entrepriseSrv, connectionService);
    this.item = new Entreprise();
  }

  ngOnInit() {}

  prepareCreation() {}

}
