import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { AlertController, ToastController } from '@ionic/angular';

@Component({
  selector: 'app-tabs',
  templateUrl: './tabs.component.html',
  styleUrls: ['./tabs.component.scss'],
})
export class TabsComponent implements OnInit {
  constructor(
    private router: Router,
    private alertController: AlertController,
    private toastController: ToastController
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

  logout() {
    this.alertController.create({
      header: 'Logout',
      message: 'Are you sure want to logout?',
      buttons: [
        {
          text: 'Cancel',
          role: 'cancel'
        },
        {
          text: 'Logout',
          handler: () => {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            this.router.navigate(['/welcome']);

            this.toastController.create({
              message: 'Logout success',
              duration: 2000,
              color: 'success'
            }).then(toast => {
              toast.present();
            });
          }
        }
      ]
    }).then(alert => {
      alert.present();
    });
  }
}
