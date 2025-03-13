<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>

    <style>
      .nav-tabs {
        border-bottom: none;
      }
    
      .nav-tabs .nav-link {
        font-size: 18px;
        font-weight: bold;
        color: #6c757d;
        padding: 10px 20px;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
      }
    
      .nav-tabs .nav-link.active {
        background-color: #3f51b5;
        color: white;
        border: none;
      }
    
      .tab-content {
        border: 1px solid #ddd;
        border-radius: 0 0 8px 8px;
        padding: 15px;
        background: white;
      }
    
      .custom-box {
        background: white;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
      }

      /* .custom-table {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .custom-table thead {
            background: #f8f9fa;
            color: #6c757d;
            font-weight: bold;
        }
        .custom-table th, .custom-table td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }
        .badge-priority {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 14px;
        }
        .deadline {
            color: red;
            font-weight: bold;
        } */

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #eceaf6;
            padding: 20px;
        }
        .sidebar .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #3f51b5;
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background-color: #3f51b5;
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 20px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
      <h4 class="text-primary fw-bold mb-4"><img src="/Applications/MAMP/htdocs/cluster3/public/logo WRS.png" class="me-2"> </h4>
      <a href="#" class="nav-link active"><i class="bi bi-house-door"></i> หน้าหลัก</a>
      <a href="#" class="nav-link"><i class="bi bi-file-earmark-plus"></i> สร้างใบสั่งงาน</a>
      <a href="#" class="nav-link"><i class="bi bi-file-earmark-text"></i> แบบร่าง</a>
      <a href="#" class="nav-link"><i class="bi bi-send"></i> ส่งแล้ว</a>
      <a href="#" class="nav-link"><i class="bi bi-archive"></i> จัดเก็บ</a>
      <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> รายงาน</a>
    </div>
  
    <!-- Content -->
    <div class="content">
      <div v-if="mode=='form'">
        <div class="container-fluid mt-2">
          <div class="container mt-4 ">
            <div class="row">
              <div class="col">
                  <h2 class="text-primary">รายการงาน</h2>
                </div>
                <div class="col">
                  <ul class="nav nav-tabs d-flex justify-content-end ">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#myTasks">ใบงานของฉัน</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#teamTasks">ใบงานของแผนก</button>
                    </li>
                  </ul>
                </div>
              
            </div>
            </ul>
      
      
            <div class="tab-content mt-3">
              <div class="tab-pane fade show active" id="myTasks">
                <div class="custom-box">
                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#received1">งานที่ได้รับ</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inProgress1">กำลังดำเนินการ</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed1">เสร็จสิ้น</button>
                    </li>
                  </ul>
      
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="received1">
                      <div class="container ">
                        <table class="table custom-table">
                          <thead>
                            <tr>
                              <th>ชื่อใบงาน</th>
                              <th>ชื่องาน</th>
                              <th>ผู้มอบหมาย</th>
                              <th>ความสำคัญ</th>
                              <th>กำหนดส่ง</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="inProgress1">
                      <table class="table custom-table">
                        <thead>
                          <tr>
                            <th>ชื่อใบงาน</th>
                            <th>ชื่องาน</th>
                            <th>ผู้มอบหมาย</th>
                            <th>ความสำคัญ</th>
                            <th>กำหนดส่ง</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                      
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="completed1">
                        <table class="table custom-table">
                          <thead>
                            <tr>
                              <th>ชื่อใบงาน</th>
                              <th>ชื่องาน</th>
                              <th>ผู้มอบหมาย</th>
                              <th>ความสำคัญ</th>
                              <th>กำหนดส่ง</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                        
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
      
              <div class="tab-pane fade" id="teamTasks">
                <div class="container mt-4">
      
                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#received">งานที่ได้รับ</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inProgress">กำลังดำเนินการ</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed">เสร็จสิ้น</button>
                    </li>
                  </ul>
      
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="received">
                        <table class="table custom-table">
                          <thead>
                            <tr>
                              <th>ชื่อใบงาน</th>
                              <th>ชื่องาน</th>
                              <th>ผู้มอบหมาย</th>
                              <th>ความสำคัญ</th>
                              <th>กำหนดส่ง</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                        
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="inProgress">
                        <table class="table custom-table">
                          <thead>
                            <tr>
                              <th>ชื่อใบงาน</th>
                              <th>ชื่องาน</th>
                              <th>ผู้มอบหมาย</th>
                              <th>ความสำคัญ</th>
                              <th>กำหนดส่ง</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                        
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="completed">
                        <table class="table custom-table">
                          <thead>
                            <tr>
                              <th>ชื่อใบงาน</th>
                              <th>ชื่องาน</th>
                              <th>ผู้มอบหมาย</th>
                              <th>ความสำคัญ</th>
                              <th>กำหนดส่ง</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                        
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white">
    
  
  </div>
  </body>
</html>