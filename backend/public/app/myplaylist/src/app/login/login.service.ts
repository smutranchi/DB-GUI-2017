import { Injectable } from '@angular/core';
import { Http, Headers } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()

export class LoginService {
    constructor(private http: Http){}
        
    postLogin(_body) {
        const url = '/login';
        const headers = new Headers({'Content-Type': 'application/json'});
        const body = JSON.stringify(_body);
        return this.http.post(url, body, { headers})
        .toPromise()
        .then(res => res.json()); 
    
    }
}
