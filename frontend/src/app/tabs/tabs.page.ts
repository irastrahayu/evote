import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-tabs',
  templateUrl: './tabs.page.html',
  styleUrls: ['./tabs.page.scss'],
})
export class TabsPage implements OnInit {

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.checkToken();
  }

  checkToken() {
    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    if (token && role) {
      if (role === 'user')
        this.router.navigate(['/tabs/home']);
      else if (role === 'admin')
        this.router.navigate(['/admin']);
    } else {
      this.router.navigate(['/welcome']);
    }
  }
}
