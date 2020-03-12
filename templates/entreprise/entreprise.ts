import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Entreprise extends BamboObject {
    id: any;
                                nom: string;
                                        telephone: string;
                                        ninea: string;
                                        email: string;
                                        adresse: string;
                                        nomPrenomPatron: string;
                                        gerant: string;
                                        telephoneGerant: string;
                                        telephonePatron: string;
                                        description: string;
                        
    constructor() {
        super();
    }
}
