import { AlertController, ModalController, ToastController } from '@ionic/angular';
import { Component, OnInit } from '@angular/core';
import { environment } from 'src/environments/environment';
import { AddUserModalComponent } from '../modals/add-user-modal/add-user-modal.component';
import { EditUserModalComponent } from '../modals/edit-user-modal/edit-user-modal.component';

@Component({
  selector: 'app-user',
  templateUrl: './user.page.html',
  styleUrls: ['./user.page.scss'],
})
export class UserPage implements OnInit {
  data: any = [];
  constructor(
    private toastController: ToastController,
    private modalController: ModalController,
    private alertController: AlertController
  ) { }

  ngOnInit() {
    this.getAllUser();
  }

  addUser() {
    this.modalController.create({
      component: AddUserModalComponent
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllUser();
      });
    });
  }

  editUser(data: any) {
    this.modalController.create({
      component: EditUserModalComponent,
      componentProps: {
        data: data
      }
    }).then(modal => {
      modal.present();
      modal.onDidDismiss().then(() => {
        this.getAllUser();
      });
    });
  }

  deleteUser(data: any) {
    try {
      const alert = this.alertController.create({
        header: 'Delete User',
        message: 'Are you sure you want to delete this user?',
        buttons: [
          {
            text: 'Cancel',
            role: 'cancel'
          },
          {
            text: 'Delete',
            handler: () => {
              this.delete(data);
            }
          }
        ]
      });

      alert.then(alert => {
        alert.present();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async delete(id: any) {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/user/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.getAllUser();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async getAllUser() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/user`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      this.data = json.data;
    } catch (err: any) {
      this.toastController.create({
        message: err.message,
        duration: 2000,
      }).then(toast => toast.present());
    }
  }
}
