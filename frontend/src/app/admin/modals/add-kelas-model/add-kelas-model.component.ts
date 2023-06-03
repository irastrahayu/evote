import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-add-kelas-model',
  templateUrl: './add-kelas-model.component.html',
  styleUrls: ['./add-kelas-model.component.scss'],
})
export class AddKelasModelComponent implements OnInit {
  @Input() data: any;

  form: any = {}
  jurusans: any = [];
  constructor(
    private modalController: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.getAllJurusan();
  }

  close() { }

  async create() {
    if (!this.form.id_jurusan || !this.form.nama) return this.toastController.create({
      message: 'Semua form wajib diisi',
      duration: 2000
    }).then(toast => toast.present());

    try {
      const res = await fetch(`${environment.BASE_URL}admin/kelas`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(this.form)
      });

      const json = await res.json();
      if (res.status !== 201) {
        return this.toastController.create({
          message: json.message,
          duration: 2000
        }).then(toast => toast.present());
      }

      this.toastController.create({
        message: json.message,
        duration: 2000
      }).then(toast => {
        toast.present();
        this.modalController.dismiss();
      });
    } catch (err) {
      console.log(err);
    }
  }

  async getAllJurusan() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/jurusan`, {
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
          duration: 2000
        }).then(toast => toast.present());
        return;
      }

      this.jurusans = json.data;
    } catch (err) {
      console.log(err);
    }
  }
}
