import requests
import pymysql
import time
import subprocess
from configs import configs

import sys
from PySide2 import QtCore
from PySide2.QtGui import (QColor)
from PySide2.QtWidgets import *

from ui_splash_screen import Ui_SplashScreen

counter = 0
database = pymysql.connect(host=configs["database_host"],
                           user=configs["database_user"],
                           password=configs["database_password"],
                           database=configs["database_db"],
                           cursorclass=pymysql.cursors.DictCursor)

# Получаем актуальную версию
with database:
    cursor = database.cursor()
    cursor.execute("SELECT `{0}` FROM `{1}` WHERE 1".format(configs["database_version_column"],
                                                            configs["database_table_name"]))
    version_db = cursor.fetchall()[0][configs["database_version_column"]]
    print(f"Актуальная версия - {version_db}")

# Получаем текущую версию
with open(configs["version_file_path"], "r+") as version_file_cur:
    current_version = version_file_cur.read()
    try:
        current_version = int(current_version)
    except ValueError:
        current_version = 0
    print(f"Текущая версия - {current_version}")


def check_version():
    with open(configs["version_file_path"], "r+") as version_file:
        if version_db > current_version:
            with open(configs["app_version_file_path"], "wb") as current_package_file:
                print("Скачиваю новую версию приложения...")
                package_file_server = requests.get(configs["update_version_server_file"])
                current_package_file.write(package_file_server.content)
                version_file.seek(0)
                version_file.write(str(version_db))
                time.sleep(2)


class SplashScreen(QMainWindow):
    def __init__(self, parent=None):
        super().__init__(parent)
        self.ui = Ui_SplashScreen()
        self.ui.setupUi(self)

        # REMOVE TITLE BAR
        self.setWindowFlag(QtCore.Qt.FramelessWindowHint)
        self.setAttribute(QtCore.Qt.WA_TranslucentBackground)

        # DROP SHADOW EFFECT
        self.shadow = QGraphicsDropShadowEffect(self)
        self.shadow.setBlurRadius(20)
        self.shadow.setXOffset(0)
        self.shadow.setYOffset(0)
        self.shadow.setColor(QColor(0, 0, 0, 60))
        self.ui.dropShadowFrame.setGraphicsEffect(self.shadow)

        # QTIMER ==> START
        self.timer = QtCore.QTimer()
        self.timer.timeout.connect(self.progress)
        # TIMER IN MILLISECONDS
        self.timer.start(35)

        self.ui.label_current_version.setText(f'<html><head/><body><p><span style=" font-weight:600;">'
                                              f'Current version: </span>1.{version_db}</p></body></html>')
        self.ui.label_actual_version.setText(f'<html><head/><body><p><span style=" font-weight:600;">'
                                             f'Actual version: </span>1.{current_version}</p></body></html>')

        QtCore.QTimer.singleShot(1500, lambda: check_version())

        self.show()

    # APP FUNCTIONS
    def progress(self):
        global counter
        self.ui.progressBar.setValue(counter)

        if counter > 100:
            self.timer.stop()
            subprocess.Popen(configs["app_exe_path"])
            self.close()

        counter += 1


if __name__ == "__main__":
    app = QApplication(sys.argv)
    window = SplashScreen()
    sys.exit(app.exec_())
