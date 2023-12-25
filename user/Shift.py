import pandas as pd
from etutor.settings import MEDIA_ROOT

class Shift:
    assign = list()
    times = list() # 記錄所有時間段
    error = list()
    
    info_kidSchool = dict()
    info_kidMate = list()
    info_uniMate = list()

    # 錯誤參數設定(預設權重 1)
    opt_assign_score = 10
    opt_limit_score = 10
    opt_subj_socre = 10

    @staticmethod
    def get_time_id(day, startTime, endTime):

        # 在 times 搜尋該時間
        for tID in range(len(Shift.times)):
            # 已經存在 times
            if (Shift.times[tID]['day'] == day 
                and Shift.times[tID]['startTime'] == int(startTime.replace(":","").replace("：",""))
                and Shift.times[tID]['endTime'] == int(endTime.replace(":","").replace("：",""))):
                return tID # return tId

        # 還不存在該時間在 times
        tmp = { # 建立該筆 time
            'day' : day,
            'startTime' : int(startTime.replace(":","").replace("：","")),
            'endTime' : int(endTime.replace(":","").replace("：","")),
        }
        Shift.times.append(tmp)
        return len(Shift.times)-1 # return tId
    
    '''
    ex: 國中英文
    eduStage + subj
    eduStage = 國中, 國小
    subj = 英文、國語、數學
    '''
    @staticmethod
    def get_subjToken(subjName):
        eduStage = subjName[:2]
        subj = subjName[2:]
        subjToken = ""
        
        # educational stage
        if (eduStage == "國中"):
            subjToken = 'j'
        elif (eduStage == "國小"):
            subjToken = 'e'
        
        # subject
        if (subj == '國語'):
            subjToken += 'Zh'
        elif (subj == '英文'):
            subjToken += 'En'
        elif (subj == '數學'):
            subjToken += 'Math'
        
        return subjToken

    @staticmethod
    def get_dayToken(day):
        dayToken = False
        if(day == "週一"):
            dayToken = "1"
        elif (day == "週二"):
            dayToken = "2"
        elif (day == "週三"):
            dayToken = "3"
        elif (day == "週四"):
            dayToken = "4"
        elif (day == "週五"):
            dayToken = "5"
        return dayToken
    
    @staticmethod
    def decode_day(day):
        dayMap = {
            1: "週一",
            2: "週二",
            3: "週三",
            4: "週四",
            5: "週五",
            6: "週六",
            7: "週日",
        }
        return dayMap[int(day)]

    @staticmethod
    def decode_subj(subj):
        subjMap = {
            'eZh': "國小國語",
            'eMath': "國小數學",
            'eEn': "國小英文",
            'jZh': "國中國語",
            'jMath': "國中數學",
            'jEn': "國中英文",
        }
        return subjMap[subj]

    @staticmethod
    def create_school_info(df_kidSchool):
        Shift.times = []
        Shift.info_kidSchool = {}

        for index, row in df_kidSchool.iterrows():
            
            # school_name (name + edu stage)
            name = row['name'] + row['edu stage']
            
            # create times
            tIDs = list()
            days = row['day'].split(';')
            for day in days:
                tIDs.append( Shift.get_time_id(day, row['startTime'], row['endTime']) )
            
            # subj
            subjs = row['subj'].split(";")
            subjTokens = list()
            for sub in subjs:
                subjTokens.append(Shift.get_subjToken(row['edu stage']+sub))
                
            tmp = {
                'times': tIDs,
                'subjs': subjTokens,
            }
            
            Shift.info_kidSchool.update({name: tmp})
        return Shift.info_kidSchool

    @staticmethod
    def create_kidMate_info(df_kidMate):
        Shift.info_kidMate = []

        for index, row in df_kidMate.iterrows():
            school = row['school']+row['edu stage']
            tmp = {
                'name': row['name'],
                'school': school,
                'subjs': Shift.info_kidSchool[school]['subjs'],
                'avaTimes': Shift.info_kidSchool[school]['times'],
            }
            Shift.info_kidMate.append(tmp)
        return Shift.info_kidMate

    def get_kidMate_id(school, name):
        # 尋找該名小學伴
        for kidID in range(len(Shift.info_kidMate)):
            if ( Shift.info_kidMate[kidID]['name'] == name 
                and Shift.info_kidMate[kidID]['school'] == school):
                return kidID
        # 找不到
        return False

    @staticmethod
    def create_uniMate_info(df_uniMate):
        Shift.assign = []
        Shift.info_uniMate = []
        Shift.error = []

        for index, row in df_uniMate.iterrows():
            tIDs = list()
            for timeInfo in row['available time'].split(";"):
                day, time = timeInfo.split(" ")
                startTime, endTime = time.split("~")
                tIDs.append(Shift.get_time_id(Shift.get_dayToken(day), startTime, endTime) )
            
            subjs = list()
            for subj in row['subject'].split(";"):
                subjs.append(Shift.get_subjToken(subj))

            # 指定的小學伴
            if(not pd.isnull(row['assign'])):
                for kidInfo in str(row['assign'].replace("；",";").replace("／","/")).split(';'):
                    assign = dict()
                    kidName, school = kidInfo.split('/')
                    kidID = Shift.get_kidMate_id(school, kidName)
                    if(kidID):
                        assign.update({'kidID':kidID})
                        assign.update({'uniID':len(Shift.info_uniMate)})
                        Shift.assign.append(assign)
                    else:
                        Shift.error.append("「"+ str(row['stuID']) + " " + row['name'] + "」指定小學伴「"+ kidInfo +"」")
                
            tmp = {
                'name': row['name'],
                'stuID': row['stuID'],
                'status': row['status'],
                'limit': row['limit'],
                'avaTimes': tIDs,
                'subjs': subjs,
                'assign': row['assign']
            }
            Shift.info_uniMate.append(tmp)
        
        return Shift.info_uniMate

    def __init__(self, comb):
        self.comb = comb
        self.error = list()

    def get_fitness(self, genes):
        self.isFit = True

        if Shift.error != []:
            self.isFit = False
        
        self.error = {
            "nameErr": Shift.error.copy(),
            "assignErr": list(),
            "fitErr": list(),
            "limitErr": list(),
            "noKidErr": list(),
        }

        self.result = list()
        self.stuNum = list()
        self.stuList = list()
        error_score = 1
        timeTB_uniMate = dict()
        avaT_kidMate = dict()

        # 初始化大學伴時間表, 學生數, 學生清單
        for uniID in range(len(Shift.info_uniMate)):
            tmp = {str(i):None for i in range(1,8)} # 紀錄大學伴每週有班的時間 {學伴ID:{星期:list(times)}
            timeTB_uniMate.update({uniID:tmp})
            self.stuNum.append(0)
            self.stuList.append([])

        for kidID in range(len(Shift.info_kidMate)):
            tmp = dict()
            for avaTime in Shift.info_kidMate[kidID]['avaTimes']:
                tmp.update({avaTime:True})
            avaT_kidMate.update({kidID:tmp})

        for gID in range(len(genes)):
            uniID = self.comb[gID]['uniID']
            kidID = genes[gID]['kidID']
            tID = self.comb[gID]['time']
            time = Shift.times[tID]
            
            match = "「" + str(Shift.info_uniMate[uniID]['stuID']) + " " + Shift.info_uniMate[uniID]['name'] + "」"
            match += " + 「"+ str(Shift.decode_day(time['day']))+" "+ str(time['startTime'])+"~"+str(time['endTime']) + "」"
            match += " + 「"+ Shift.decode_subj(genes[gID]['subj']) +"」"
            match += " + 「"+ Shift.info_kidMate[kidID]['school']+"/"+Shift.info_kidMate[kidID]['name'] +"」"
            
            # kidMate 時間可否配合 time
            if(tID in Shift.info_kidMate[kidID]['avaTimes']):
                if(not avaT_kidMate[kidID][tID]):
                    error_score += 10
                    # self.error["fitErr"].append(match +"==> 小學伴該時段已有排課")
            else:
                error_score += 30
                # self.error["fitErr"].append(match +"==> 該時段非小學伴課程時間")

            checkTime_uniMate = False
            if(timeTB_uniMate[uniID][time['day']] == None):
                checkTime_uniMate = True
            else:
                isAva = True
                for period in timeTB_uniMate[uniID][time['day']]:
                    # if(time['startTime'] >= period['endTime'] or time['endTime'] <= period['startTime']):
                    #     checkTime_uniMate = True
                    if(time['startTime'] > period['startTime'] and time['startTime'] < period['endTime']
                        or time['endTime'] > period['startTime'] and time['endTime'] < period['endTime']
                        or time['startTime'] == period['startTime'] and time['endTime'] == period['endTime']):
                        isAva = False
                        break
                if(isAva):
                    checkTime_uniMate = True
            if(not checkTime_uniMate):
                error_score += 10
                # self.error["fitErr"].append(match +"==> 大學伴該時段已有排課")

            # uniMate 科目可否配合 subj
            checkSubj = False
            for subj in Shift.info_uniMate[uniID]['subjs']:
                if(subj == genes[gID]['subj']):
                    checkSubj = True
            if(not checkSubj):
                error_score += Shift.opt_subj_score
                self.error["fitErr"].append(match +"==> 大學伴科目不吻合")
          
            # 都符合加入排班方案
            if(tID in Shift.info_kidMate[kidID]['avaTimes'] and avaT_kidMate[kidID][tID]
                    and checkTime_uniMate
                    # and self.stuNum[uniID] < Shift.info_uniMate[uniID]['limit']
                    and checkSubj):
                self.result.append({**genes[gID], **self.comb[gID]})
                
                avaT_kidMate[kidID][tID] = False 
                period = {
                    "startTime": time['startTime'],
                    "endTime": time['endTime'],
                }

                self.stuNum[uniID] += 1
                self.stuList[uniID].append(kidID)
                if(timeTB_uniMate[uniID][time['day']] == None):
                    timeTB_uniMate[uniID][time['day']] = [period]
                else:
                    timeTB_uniMate[uniID][time['day']].append(period)
            else:
                tmp = {
                    "gID": gID,
                    "kidID": kidID,
                    "subj": genes[gID]['subj'],
                    "uniID": None,
                    "time": tID,
                }
                self.result.append(tmp)

        # 確認 assign 有沒有達成
        for assign in Shift.assign:
            fitAssign = False
            for result in self.result:
                if(assign['kidID'] == result['kidID']
                    and assign['uniID'] == result['uniID']):
                    fitAssign = True
                    break
            if(not fitAssign):
                # error_score += Shift.opt_assign_score
                error_score += 50
                self.error["assignErr"].append("「" + str(Shift.info_uniMate[assign['uniID']]['stuID']) +" " +Shift.info_uniMate[assign['uniID']]['name'] + "」指定小學伴「" + Shift.info_kidMate[assign['kidID']]['school'] +"/"+ Shift.info_kidMate[assign['kidID']]['name'] +"」")
        
        # 確認每個 uniMate 都有小學伴 & 有沒有超額
        for uniID in range(len(Shift.info_uniMate)):
            if(self.stuNum[uniID] == 0):
                error_score += 20
                self.error["noKidErr"].append(str(Shift.info_uniMate[uniID]['stuID']) + " " + Shift.info_uniMate[uniID]['name'])

            elif(self.stuNum[uniID] > Shift.info_uniMate[uniID]['limit']):
                error_score += Shift.opt_limit_score
                kids = ""
                for kidID in self.stuList[uniID]:
                    kids += Shift.info_kidMate[kidID]['school'] + "/" +Shift.info_kidMate[kidID]['name'] + ", "
                self.error["limitErr"].append("大學伴「" + str(Shift.info_uniMate[uniID]['stuID']) + " " + Shift.info_uniMate[uniID]['name'] +"」所帶小學伴數量超過其設定上限 ( "+ str(Shift.info_uniMate[uniID]['limit'])+" ) ==> " + kids[:-2])

        self.fitness = 1/error_score
        return self.fitness

    def get_result(self):
        df_list = list()
        for result in self.result:
            kidMate = Shift.info_kidMate[result['kidID']]
            if(result['uniID'] == None):
                uniMate_name = None
            else:
                uniMate = Shift.info_uniMate[result['uniID']]
                uniMate_name = Shift.info_uniMate[result['uniID']]['name']
            subj = result['subj']
            time = Shift.times[result['time']]
            tmp = [
                kidMate['school'],
                kidMate['name'],
                Shift.decode_day(time['day'])+" "+str(time['startTime'])+"~"+str(time['endTime']), #FIXME
                Shift.decode_subj(subj),
                uniMate_name,
            ]
            df_list.append(tmp)
        file_path = MEDIA_ROOT + "/tmp/result.csv"
        df = pd.DataFrame(df_list, columns=["kidSchool", "kidMate", "time", 'subj', "uniMate"])
        df.sort_values(by=['kidSchool','kidMate','time']).to_csv(file_path, index=False)
        return df.sort_values(by=['kidSchool','kidMate','time'])

    def get_uniMate_status(self):
        df_list = list()
        for uniID in range(len(Shift.info_uniMate)):
            
            stus = ""
            for kidID in self.stuList[uniID]:
                stus += Shift.info_kidMate[kidID]['school'] + "/" +Shift.info_kidMate[kidID]['name'] + ", "

            subjs = ""
            for subj in Shift.info_uniMate[uniID]['subjs']:
                subjs += Shift.decode_subj(subj) + ", "

            avaTimes = ""
            for tID in Shift.info_uniMate[uniID]['avaTimes']:
                day = Shift.decode_day(Shift.times[tID]['day'])
                startTime = Shift.times[tID]['startTime']
                endTime = Shift.times[tID]['endTime']
                avaTimes += day + " " + str(startTime) + "~" + str(endTime) + ", "

            tmp = [
                Shift.info_uniMate[uniID]['stuID'],
                Shift.info_uniMate[uniID]['name'],
                Shift.info_uniMate[uniID]['limit'],
                Shift.info_uniMate[uniID]['limit'] - self.stuNum[uniID],
                subjs[:-2],
                avaTimes[:-2],
                stus[:-2],
            ]
            df_list.append(tmp)
        
        file_path = MEDIA_ROOT + "/tmp/result_uniMate_status.csv"
        df = pd.DataFrame(df_list, columns=["學號", "姓名", "人數上限", '還可以帶的數量', "科目", "可以的時間", "當前帶的小學伴"])
        df.sort_values(by=['還可以帶的數量','學號'], ascending=False).to_csv(file_path, index=False)
