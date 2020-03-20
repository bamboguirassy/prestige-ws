import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Fournisseur extends BamboObject {
    id: any;
                                nom: string;
                                        telephone: string;
                                        adresse: string;
                                        description: string;
                                        logo: string;
                                        logoUrl: string;
                        
    constructor() {
        super();
    }
}
