import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  @Input() component: String;
  title = 'app.component.ts';
  show = true;

  constructor() {
    if (this.component === 'register') {
      this.show = true;
    }
    else {
      this.show = false;
    }
  }
}
