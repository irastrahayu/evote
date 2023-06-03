import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-user-modal',
  templateUrl: './edit-user-modal.component.html',
  styleUrls: ['./edit-user-modal.component.scss'],
})
export class EditUserModalComponent implements OnInit {
  @Input() data: any;
  aKelas: any = [];
  form: any = {}
  role: any;

  constructor(
    private toastController: ToastController,
    private modalController: ModalController
  ) { }

  ngOnInit() {
    this.form.name = this.data.name;
    this.form.email = this.data.email;
    this.form.nis = this.data.nis;
    this.form.id_kelas = this.data.id_kelas;
    this.role = this.data.role;

    this.getAllKelas();
  }

  async getAllKelas() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/kelas`, {
        method: 'GET',
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

      this.aKelas = json.data;
    } catch (err) {
      console.log(err);
    }
  }

  changeRole(event: any) {
    this.role = event.detail.value;
  }

  close() {
    this.modalController.dismiss();
  }

  async update() {
    try {
      let body: any = {};
      switch (this.role) {
        case 'user':
          body.name = this.form.name;
          body.nis = this.form.nis;
          body.email = this.form.email;
          body.id_kelas = this.form.id_kelas;
          body.password = this.form.password;
          body.role = this.role ? this.role : 'user';
          break;

        case 'admin':
          body.name = this.form.name;
          body.email = this.form.email;
          body.password = this.form.password;
          body.role = this.role ? this.role : 'user';
      }

      const res = await fetch(`${environment.BASE_URL}admin/user/${this.data.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(body)
      });

      const json = await res.json();
      if (res.status !== 201) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });

        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.modalController.dismiss();
      });
    } catch (err) {
      console.log(err);
    }
  }
}
