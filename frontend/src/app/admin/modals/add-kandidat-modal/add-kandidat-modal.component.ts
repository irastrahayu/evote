import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-add-kandidat-modal',
  templateUrl: './add-kandidat-modal.component.html',
  styleUrls: ['./add-kandidat-modal.component.scss'],
})
export class AddKandidatModalComponent implements OnInit {
  @Input() data: any;
  form: any = {};
  aKelas: any = [];
  constructor(
    private modalController: ModalController,
    private toastControlller: ToastController
  ) { }

  ngOnInit() {
    this.getAllKelas();
    console.log(this.data);
  }

  uploadFile(event: any) {
    this.form.image = event.target.files[0];
  }

  async create() {
    try {
      if (!this.form.nama_ketua || !this.form.nama_wakil || !this.form.id_kelas_ketua || !this.form.id_kelas_wakil || !this.form.image || !this.form.visi || !this.form.misi) {
        this.toastControlller.create({
          message: 'Semua form wajib diisi',
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });
        return;
      }

      const formData = new FormData();
      formData.append('nama_ketua', this.form.nama_ketua);
      formData.append('nama_wakil', this.form.nama_wakil);
      formData.append('id_kelas_ketua', this.form.id_kelas_ketua);
      formData.append('id_kelas_wakil', this.form.id_kelas_wakil);
      formData.append('image', this.form.image);
      formData.append('visi', this.form.visi);
      formData.append('misi', this.form.misi);
      formData.append('id_pemilihan', this.data.id);

      const res = await fetch(`${environment.BASE_URL}admin/kandidat`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: formData
      });

      const json = await res.json();
      if (res.status !== 201) {
        this.toastControlller.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });
        return;
      }

      this.toastControlller.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.close();
      });
    } catch (err: any) {
      this.toastControlller.create({
        message: err.message,
        duration: 2000,
        color: 'danger'
      }).then(toast => {
        toast.present();
      });
    }
  }

  close() {
    this.modalController.dismiss();
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
        this.toastControlller.create({
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
}
