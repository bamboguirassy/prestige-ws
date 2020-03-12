import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { EntrepriseService } from '../entreprise.service';
import { DialogService } from 'primeng/api';
import { EntrepriseNewComponent } from '../entreprise-new/entreprise-new.component';
import { Entreprise } from '../entreprise';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-entreprise-picklist',
  templateUrl: './entreprise-picklist.component.html',
  styleUrls: ['./entreprise-picklist.component.css'],
  providers: [DialogService]
})
export class EntreprisePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public entrepriseSrv: EntrepriseService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(entrepriseSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(EntrepriseNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Entreprise) => {
      if (item) {
        this.items = [item, ...this.items];
        this.entrepriseSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
