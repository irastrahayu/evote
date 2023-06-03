import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { TabsComponent } from './admin/tabs/tabs.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'welcome',
    pathMatch: 'full'
  },
  {
    path: 'tabs',
    redirectTo: 'tabs/home',
    pathMatch: 'full'
  },
  {
    path: 'login',
    loadChildren: () => import('./login/login.module').then(m => m.LoginPageModule)
  },
  {
    path: 'signup',
    loadChildren: () => import('./signup/signup.module').then(m => m.SignupPageModule)
  },
  {
    path: 'welcome',
    loadChildren: () => import('./welcome/welcome.module').then(m => m.WelcomePageModule)
  },
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule)
  },
  {
    path: 'admin',
    component: TabsComponent,
    children: [
      {
        path: '',
        redirectTo: 'dashboard',
        pathMatch: 'full'
      },
      {
        path: 'dashboard',
        loadChildren: () => import('./admin/dashboard/dashboard.module').then(m => m.DashboardPageModule)
      },
      {
        path: 'pemilihan',
        loadChildren: () => import('./admin/pemilihan/pemilihan.module').then(m => m.PemilihanPageModule)
      },
      {
        path: 'settings',
        loadChildren: () => import('./admin/settings/settings.module').then(m => m.SettingsPageModule)
      },
      {
        path: 'kandidat',
        loadChildren: () => import('./admin/kandidat/kandidat.module').then(m => m.KandidatPageModule)
      },
      {
        path: 'kelas',
        loadChildren: () => import('./admin/kelas/kelas.module').then(m => m.KelasPageModule)
      },
      {
        path: 'jurusan',
        loadChildren: () => import('./admin/jurusan/jurusan.module').then(m => m.JurusanPageModule)
      },
      {
        path: 'user',
        loadChildren: () => import('./admin/user/user.module').then(m => m.UserPageModule)
      },
    ]
  },
  {
    path: 'admin/login',
    loadChildren: () => import('./admin/login/login.module').then(m => m.LoginPageModule)
  },

];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
