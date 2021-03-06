import random
import copy
import mysql.connector
from .DBConfig import DBConfig
from .Student import Student

class StudentsManager:

    def __init__(self, group_id):
        self.group_id = group_id
        self.students = []
        self._load_students_from_db(self.group_id)
        random.shuffle(self.students)
        self.checkout_students = copy.deepcopy(self.students)

    def _load_students_from_db(self, group_id):
        connection = mysql.connector.connect(
                        user=DBConfig.user,
                        password=DBConfig.password,
                        host=DBConfig.host,
                        database=DBConfig.database)

        cursor = connection.cursor()

        query = "SELECT * FROM alunni WHERE id_gruppo = " + group_id + ";"

        cursor.execute(query)

        self.students = cursor.fetchall()

        self.students = [Student(student_record) for student_record in self.students]

        cursor.close()

        connection.close()

    def get_uninserted_students(self, containers_manager):
        inserted_students_matricola = containers_manager.get_all_inserted_students_matricola()
        all_students_matricola = set([student.matricola for student in self.checkout_students])

        uninserted_students_matricola = []
        for matricola in all_students_matricola:
            if matricola not in inserted_students_matricola:
                uninserted_students_matricola.append(matricola)

        return set(uninserted_students_matricola)

    def get_number_of_students(self):
        return len(self.students)

    def get_sex_prioritized_students_array(self, sex_priority, num_sex_priority):
        sex_priority_students = []
        othersex_students = []
        for student in self.students:
            if student.sesso == sex_priority:
                sex_priority_students.append(student)
            else:
                othersex_students.append(student)

        for student in sex_priority_students:
            self.students.remove(student)

        sex_priority_students_groupped = {
            "female-only" : [],
            "female-female" : {},
            "female-male" : {}
        }

        sex_priority_students_without_desiderata = []
        for student in sex_priority_students:
            has_desiderata = False
            for other in sex_priority_students:
                if student.check_desiderata(other):
                    has_desiderata = True
                    if other.matricola + "-" + student.matricola \
                        not in sex_priority_students_groupped["female-female"].keys():
                        print("Matched S-S! " + student.matricola + " <--> " + other.matricola)
                        sex_priority_students_groupped["female-female"][
                            student.matricola + "-" + other.matricola
                        ] = [student, other]
            if not has_desiderata:
                sex_priority_students_without_desiderata.append(student)


        othersex_to_remove_from_students = []
        for student in sex_priority_students:
            has_desiderata = False
            for other in othersex_students:
                if student.check_desiderata(other):
                    has_desiderata = True
                    if other.matricola + "-" + student.matricola \
                        not in sex_priority_students_groupped["female-male"].keys():
                        print("Matched S-O! " + student.matricola + " <--> " + other.matricola)
                        sex_priority_students_groupped["female-male"][
                            student.matricola + "-" + other.matricola
                        ] = [student, other]
                        othersex_to_remove_from_students.append(student)
                        othersex_to_remove_from_students.append(other)
            if has_desiderata and student in sex_priority_students_without_desiderata:
                sex_priority_students_without_desiderata.remove(student)


        for student in othersex_to_remove_from_students:
            if student in self.students:
                self.students.remove(student)

        random.shuffle(sex_priority_students_without_desiderata)

        index = 0
        arranged_students_based_on_config = [[]]
        for student_couple in sex_priority_students_groupped["female-female"].values():
            if len(arranged_students_based_on_config[index]) + 2 > num_sex_priority:
                arranged_students_based_on_config.append([])
                index += 1

            arranged_students_based_on_config[index].append(student_couple[0])
            arranged_students_based_on_config[index].append(student_couple[1])

        index = 0
        for student_couple in sex_priority_students_groupped["female-male"].values():
            while len(arranged_students_based_on_config[index]) + 1 > num_sex_priority:
                index += 1
            arranged_students_based_on_config.append([])
            arranged_students_based_on_config[index].append(student_couple[0])
            arranged_students_based_on_config[index].append(student_couple[1])

        index = 0
        sex_priority_students_without_desiderata_coupled = [[]]
        for student in sex_priority_students_without_desiderata:
            if len(sex_priority_students_without_desiderata_coupled[index]) >= 2:
                sex_priority_students_without_desiderata_coupled.append([])
                index += 1
            sex_priority_students_without_desiderata_coupled[index].append(student)

        index = 0
        for student_couple in sex_priority_students_without_desiderata_coupled:
            while len(arranged_students_based_on_config[index]) + 2 > num_sex_priority:
                arranged_students_based_on_config.append([])
                index += 1

            arranged_students_based_on_config[index].append(student_couple[0])
            try:
                arranged_students_based_on_config[index].append(student_couple[1])
            except: 
                pass # odd number of sex_priority_students_without_desiderata

        result_set = []
        for array in arranged_students_based_on_config:
            if len(array) > 0:
                result_set.append(array)

        return result_set


    def get_remaining_desiderata_students_array(self):
        result_set = {}

        to_remove_from_students = []
        for student in self.students:
            for other in self.students:
                if student.check_desiderata(other):
                    if other.matricola + "-" + student.matricola \
                        not in result_set.keys():
                        print("Matched O-O! " + student.matricola + " <--> " + other.matricola)
                        result_set[
                            student.matricola + "-" + other.matricola
                        ] = [student, other]
                        to_remove_from_students.append(student)
                        to_remove_from_students.append(other)

        for student in to_remove_from_students:
            if student in self.students:
                self.students.remove(student)

        result_set = [value for value in result_set.values()]
        return result_set

    def get_remaining_students_array(self):
        return self.students

    def get_number_of_remaining_students(self):
        return len(self.students)
