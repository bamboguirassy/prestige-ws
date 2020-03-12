import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { FonctionnaliteService } from '../fonctionnalite.service';
import { DialogService } from 'primeng/api';
import { FonctionnaliteNewComponent } from '../fonctionnalite-new/fonctionnalite-new.component';
import { Fonctionnalite } from '../fonctionnalite';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-fonctionnalite-picklist',
  templateUrl: './fonctionnalite-picklist.component.html',
  styleUrls: ['./fonctionnalite-picklist.component.css'],
  providers: [DialogService]
})
export class FonctionnalitePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public fonctionnaliteSrv: FonctionnaliteService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(fonctionnaliteSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(FonctionnaliteNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Fonctionnalite) => {
      if (item) {
        this.items = [item, ...this.items];
        this.fonctionnaliteSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
