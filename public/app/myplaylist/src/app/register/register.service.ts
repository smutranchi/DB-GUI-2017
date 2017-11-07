import { Injectable } from '@angular/core';
import { Http, Headers } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()

export class RegisterService {
    constructor(private http: Http){}

    postRegister(_body) {
        const url = '/register';
        const headers = new Headers({'Content-Type': 'application/json'});
        const body = JSON.stringify(_body);
        return this.http.post(url, body, { headers})
        .toPromise()
        .then(res => res.json());     
    }

    checkUserExists(_body) {
        const url = '/checkUserExists';
        const headers = new Headers({'Content-Type': 'application/json'});
        const body = JSON.stringify(_body);
        console.log(url);
        return this.http.post(url, body, { headers})
        .toPromise()
        .then(res => res.json());     
    }
}
